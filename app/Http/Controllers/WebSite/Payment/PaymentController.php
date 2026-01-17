<?php

namespace App\Http\Controllers\WebSite\Payment;

use App\Actions\CartRefreshAction;
use App\Actions\CheckOutAction;
use App\Actions\CreateOrderAction;
use App\Actions\DepositDiplomaAction;
use App\Factories\MessageSender\MessageSenderFactory;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WebSite\CartController;
use App\Models\Dashboard\Package\Package;
use App\Models\Dashboard\PaymentMethod\PaymentMethod;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Setting\WebsiteDesign;
use App\Models\Dashboard\Student\StudentRequest;
use App\Models\Website\Cart;
use App\Models\Website\PendingPayment;
use App\Payment\PaymentContext;
use App\Payment\Strategies\MoyasarPaymentGateway;
use Illuminate\Http\Request;
use Spatie\GoogleTagManager\GoogleTagManagerFacade as GTM;

class PaymentController extends Controller
{
    protected $paymentContext;
    protected $tabbyWebhookController ;
    protected $tamaraWebhookController ;


    public function __construct(PaymentContext $paymentContext , TabbyWebhookController $tabbyWebhookController , TamaraWebhookController $tamaraWebhookController)
    {
        $this->paymentContext = $paymentContext;
        $this->tabbyWebhookController = $tabbyWebhookController;
        $this->tamaraWebhookController = $tamaraWebhookController;
    }

    public function initiatePayment(Request $request)
    {
        $paymentMethod = PaymentMethod::findOrFail($request->gateway);
        $request['payment_method'] = $paymentMethod->getTranslation('name', 'en');

        $user = auth()->user()->load('my_cart');
        $cart = $user->my_cart;
        $totalAmount = $cart->total_price_after_discount;

        GTM::push([
            'event' => 'begin_checkout',
            'items' => $cart->items->map(fn($i) => [
                'item_id' =>$i->cart_type == 'training' ? $i->training_id : $i->course_id,
                'item_name' => $i->cart_type == 'training' ? $i->training?->name : $i->course?->name,
                'price' =>$i->cart_type == 'training' ? $i->training?->price : $i->course?->price,
                'quantity' => 1,
            ]),
            'value' => $cart->total_price_after_discount,
            'currency' => 'SAR'
        ]);

        // if you want to make test order///
        //(new CreateOrderAction($request))();

        $setting = Setting::firstOrFail();
        // Check if the platform type is diploma_platform or if request_ids are present
        if ($setting->platform_type == 'diploma_platform' && $request->request_ids) {
            // for deposite paying
            PendingPayment::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                ],
                [
                    'payment_method' => $request->gateway,
                    'amount' => $totalAmount,
                    'purpose' => 'deposit',
                    'payment_sub_method_name' => $request->HyperPay_type,
                ],
            );
        }

        $paymentDetails = $this->getPaymentDetails($request->gateway, $request);
        $gateway = $paymentDetails['name']['en'];

        // Set the appropriate payment gateway
        $this->paymentContext->setPaymentGateway(app($gateway));

        $successCallback = function ($result) use ($gateway) {
            if (in_array($gateway, ['Paymob', 'Moyasar', 'Tabby', 'Tamara'])) {
                // For gateways that return a redirect response

                return $result;
            }
            return response()->json(['status' => 'success', 'data' => $result]);
        };

        $failureCallback = function ($error) {
            return response()->json(['status' => 'error', 'message' => $error], 400);
        };

        return $this->paymentContext->processPayment($totalAmount, $paymentDetails, $successCallback, $failureCallback, $request);
    }

    public function handleCallback(Request $request)
    {
        $gateway = $this->detectGatewayFromReferer($request);

        //for tabby//
        if ($request->segment(4) === 'tabby') {
            $gateway = 'Tabby';
        }

        //for tamara//
        if ($request->segment(4) === 'tamara') {
            $gateway = 'Tamara';
        }

        // for madfua//
        if ($request->segment(4) === 'madfua') {
            $gateway = 'Madfua';
        }

        switch ($gateway) {
            case 'Paymob':
                $verification = $this->handlePaymobCallback($request, $gateway);
                break;
            case 'Moyasar':
                $verification = $this->handleMoyasarCallback($request, $gateway);
                break;
            case 'HyperPay':
                $verification = $this->handleHyperPayCallback($request, $gateway);
                break;
            case 'Tabby':
                $verification = $this->handleTabbyCallback($request, $gateway);
                break;
            case 'Tamara':
                $verification = $this->handleTamaraCallback($request, $gateway);
                break;
            case 'Madfua':
                $verification = $this->handleMadfuaCallback($request, $gateway);
                break;
            default:
                $verification = $this->paymentContext->verifyPayment($request->input('id') ?? $request->input('transaction_id'));
        }

        if ($verification['success']) {
            $setting = Setting::firstOrFail();
            $design = WebsiteDesign::where('is_active', 1)->firstOrFail();
            $request['payment_method'] = $gateway;
            $pending_payment = PendingPayment::where('user_id', auth()->id())->first();

            if ($design->name == 'AcSeu' && $setting->platform_type == 'diploma_platform') {
                $request['payment_method'] = $verification['payment']?->id ?? 1;
                $pending_payment = PendingPayment::where('user_id', auth()->id())
                    ->where('payment_method', $request['payment_method'])
                    ->first();

                if ($pending_payment && $pending_payment->purpose == 'deposit') {
                    $checkOutAction = new DepositDiplomaAction($request);
                    $checkOutAction();
                    session()->flash('success', __('home.Payment completed successfully. now please wait untell the acceptenece in the training'));
                    $user = auth()->user();
                    $student = $user->studentInfo()->first();
                    $student_requests = StudentRequest::where('student_id', $student->id)->where('payment_status', '!=', 'paid')->where('status', '!=', 'refused')->get();
                    return view('designs::profile.request_creation_successfull', [
                        'student_requests' => $student_requests,
                    ]);
                }
            }

            // hadnle packages first
            if ($pending_payment && $pending_payment->package_id) {
                $package = Package::findOrFail($pending_payment->package_id);
                $cart = Cart::where('user_id', auth()->id())->firstOrCreate(['user_id' => auth()->id()], ['total_price' => 0, 'total_price_after_discount' => 0, 'discount' => 0]);
                $cart->update([
                    'total_price' => $package->old_price,
                    'total_price_after_discount' => $package->price,
                    'discount' => $package->old_price - $package->price,
                ]);
                $cart->items()->delete();
                foreach ($package->courses() as $course) {
                    $cart->items()->create([
                        'course_id' => $course->id,
                        'type' => $package->type,
                    ]);
                }
            }

            //// create order after successfull payament///
            $checkOutAction = new CheckOutAction();
            $refreshAction = new CartRefreshAction();

            /// related to id of the payment record in payment method
            $refNumber = $verification['ref_number'];

            CartController::checkout($request, $checkOutAction, $refreshAction, $refNumber);

            return redirect()->route('payment.success');
        }

        return redirect()->route('payment.cancel');
    }

    // method used for assist initiate payment
    // to prepare data before sending request
    protected function getPaymentDetails(string $gateway, Request $request): array
    {
        $user = auth()->user()->load('my_cart');
        $cart = $user->my_cart;

        $baseDetails = [
            'order_id' => $request->input('order_id', uniqid('order_')),
            'user_id' => auth()->id(),
            'success_url' => route('payment.success'),
            'failure_url' => route('payment.cancel'),
        ];

        $payment_method = PaymentMethod::where('id', $gateway)->firstOrFail();
        $gatewaySpecific = match ($payment_method->getTranslation('name', 'en')) {
            'Paymob' => [
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->f_name,
                'last_name' => auth()->user()->l_name,
                'phone_number' => auth()->user()->phone,
                'street' => 'NA',
                'city' => 'NA',
                'country' => 'NA',
                'state' => 'NA',
                'postal_code' => 'NA',
                'item_name' => 'NA',
                'description' => 'NA',
            ],
            'Moyasar' => [
                'description' => $request->notes ?? 'Order Payment',
                'first_name' => auth()->user()->f_name,
                'last_name' => auth()->user()->l_name,
                'email' => auth()->user()->email,
                'phone_number' => auth()->user()->phone,
            ],
            'HyperPay' => [
                'first_name' => auth()->user()->f_name,
                'last_name' => auth()->user()->l_name,
                'email' => auth()->user()->email,
                'amount' => $request->phone,
            ],
            'Tabby' => [
                'phone_number' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->f_name,
                'last_name' => auth()->user()->l_name,
                'registered_since' => auth()->user()->created_at->subYear()->toISOString(),
                'lang' => app()->getLocale(),
                'items' => $cart->items,
                'ref_number'=> PendingPayment::where('user_id',auth()->id())->first()->ref_number,
            ],

            'Tamara' => [
                'phone_number' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->f_name,
                'last_name' => auth()->user()->l_name,
                'lang' => app()->getLocale().'_SA',
                'items' => $cart->items,
                'ref_number'=> PendingPayment::where('user_id',auth()->id())->first()->ref_number,
            ],

            'Madfua' => [
                'phone_number' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->f_name,
                'last_name' => auth()->user()->l_name,
                'lang' => app()->getLocale(),
                'items' => $cart->items,
                'ref_number'=> PendingPayment::where('user_id',auth()->id())->first()->ref_number,
            ],

            default => throw new \InvalidArgumentException('Invalid payment gateway'),
        };

        GTM::push([
            'event' => 'add_payment_info',
            'payment_type' => $payment_method->getTranslation('name', 'en'),
            'currency' => 'SAR',
            'value' => $cart->total_price_after_discount,
        ]);

        return array_merge($baseDetails, $gatewaySpecific, $request->all(), $payment_method->toArray());
    }

    protected function detectGatewayFromReferer(Request $request)
    {
        $referer = $request->header('referer');
        if ($referer == 'https://badertech.com.sa/ar/cart') {
            return 'HyperPay';
        }
        // Map referer patterns to gateway names
        $gatewayPatterns = [
            'api.moyasar.com' => 'Moyasar',
            'paymob.com' => 'Paymob',
            'eu-test.oppwa.com' => 'HyperPay',
        ];

        foreach ($gatewayPatterns as $pattern => $gateway) {
            if (str_contains($referer, $pattern)) {
                return $gateway;
            }
        }

        return 'Moyasar';
        //return null;
    }

    protected function handlePaymobCallback(Request $request, $gateway)
    {
        // Paymob-specific callback handling
        $paymentId = $request->input('id') ?? $request->input('merchant_order_id');

        if ($request->success == 'true' && $request->pending == 'false') {
            return [
                'success' => true,
                'ref_number' => $paymentId,
                'message' => 'Payment successful',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Payment verification failed',
            ];
        }
    }

    protected function handleMoyasarCallback(Request $request, $gateway)
    {
        $moyasarGateway = new MoyasarPaymentGateway();
        $secretKey = $moyasarGateway->secretKey;

        /**Verify signature if provided
        Moyasar adds a cryptographic signature to the callback URL using your secret key.
        This signature is like a seal of authenticity that proves: **/
        if (isset($_GET['signature'])) {
            $params = $_GET;
            $receivedSignature = $params['signature'];
            unset($params['signature']);

            ksort($params);
            $signatureData = '';
            foreach ($params as $key => $value) {
                $signatureData .= $key . '=' . $value . '&';
            }
            $signatureData = rtrim($signatureData, '&');

            $expectedSignature = hash_hmac('sha256', $signatureData, $secretKey);

            if (!hash_equals($expectedSignature, $receivedSignature)) {
                error_log('Invalid signature for payment: ' . $_GET['id']);
                http_response_code(403);
                exit();
            }
        }

        $paymentId = $request->input('id') ?? $request->input('transaction_id');

        $this->paymentContext->setPaymentGateway(app($gateway));

        return $this->paymentContext->verifyPayment($paymentId);
    }

    protected function handleHyperPayCallback(Request $request, $gateway)
    {
        $resourcePath = $request->input('resourcePath');
        $this->paymentContext->setPaymentGateway(app($gateway));
        return $this->paymentContext->verifyPayment($resourcePath);
    }

    protected function handleTabbyCallback(Request $request, $gateway)
    {
        $paymentId = $request->input('payment_id');
        $this->paymentContext->setPaymentGateway(app($gateway));
        return $this->tabbyWebhookController->handleWebhook($request);
    }

    protected function handleTamaraCallback(Request $request, $gateway)
    {
        $orderId = $request->input('orderId');
        $this->paymentContext->setPaymentGateway(app($gateway));
        return $this->tamaraWebhookController->handleWebhook($request);
    }

    protected function handleMadfuaCallback(Request $request, $gateway)
    {
        $merchantReference = $request->input('merchantReference');
        $this->paymentContext->setPaymentGateway(app($gateway));
        return $this->paymentContext->verifyPayment($request);
    }


    public function paymentSuccess(Request $request, CreateOrderAction $createOrderAction)
    {
        $emailSender = MessageSenderFactory::make('email');
        $emailSender->send(
            [auth()->user()],
            'emails.thanksEmail',
            __('home.Thank You'),
            __('home.Thank you for Your Payment.')
        );

        $order = auth()->user()->my_orders()->latest()->first();

        GTM::push([
            'event' => 'purchase',
            'transaction_id' => $order->id,
            'affiliation' => 'Online Platform',
            'value' => $order->total_price_after_discount,
            'currency' => 'SAR',
            'tax' => 0,
            'shipping' => 0,
            'items' => $order->items->map(fn($i) => [
                'item_id' =>$i->cart_type == 'training' ? $i->training_id : $i->course_id,
                'item_name' => $i->cart_type == 'training' ? $i->training?->name : $i->course?->name,
                'price' =>$i->cart_type == 'training' ? $i->training?->price : $i->course?->price,
                'quantity' => 1,
            ]),
        ]);

        return view('designs::PaymentMethods.success', [
            'message' => __('home.Payment completed successfully You Can Check yor Account'),
        ]);
    }

    public function paymentCancel(Request $request)
    {
        return view('designs::PaymentMethods.cancel', [
            'error' => $request->input('error', 'You aborted the payment. Please retry or choose another payment method'),
        ]);
    }

    public function paymentFail(Request $request)
    {
        return view('designs::PaymentMethods.failed', [
            'error' => $request->input('error', 'Payment was cancelled or failed'),
        ]);
    }
}
