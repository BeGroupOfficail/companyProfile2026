<!DOCTYPE html>
<html lang="{{ $lang == 'en' ? 'en' : 'ar' }}" dir="{{ $lang == 'en' ? 'ltr' : 'rtl' }}">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('css/style.css') }}">
    <link rel="stylesheet" href="{{ WebsiteHelper::getAsset('css/feather.css') }}">

    <title>@lang('home.invoice')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            padding: 30px;
            line-height: 24px;
            font-size: 14px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
    <style>
         @media print {
        .no-print {
            display: none !important;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="5">
                    <table>
                        <tr class="d-flex justify-content-between">
                            <td>
                                <img src="{{ asset('uploads/settings/' . $settings->logo) }}"
                                    alt="{{ $settings->alt_logo }}">
                            </td>
                            <td>
                                @lang('home.invoice') #: {{ $invoice->serial }}<br>
                                @lang('home.created_at'): {{ $invoice->created_at->format('d/m/Y') }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="text-right">
                                <strong>@lang('home.client')</strong><br>
                                @lang('home.name') {{ $invoice->client->user->name }}<br>
                                @lang('home.email') : {{ $invoice->client->user->email }}<br>
                                @lang('home.phone') : {{ $invoice->client->user->phone }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading text-center">
                <td>@lang('home.course')</td>
                <td>@lang('home.course_code')</td>
                <td>@lang('home.price')</td>
                <td>@lang('home.discount')</td>
                <td>@lang('home.total_price')</td>
            </tr>
            <tr class="item text-center">
                <td>{{ $invoice->training->course->name }}</td>
                <td>{{ $invoice->training->code }}</td>
                <td>{{ $invoice->invoice_value . ' ' . __('home.SAR') }}</td>
                <td>{{ $invoice->discount }}</td>
                <td>{{ $invoice->collected_amount . ' ' . __('home.SAR') }}</td>
            </tr>

            <tr class="total heading">
                <td>@lang('home.total_price')</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">{{ $invoice->collected_amount . ' ' . __('home.SAR') }}</td>
            </tr>
        </table>
        <div class="row justify-content-center align-items-center mt-5 gap-3 no-print">
            <a class="btn btn-primary col-auto gap-2" onclick="window.print()">
                <span class="button-text">@lang('home.print')
                    <i class="feather-printer"></i>
                </span>
            </a>
            <a class="btn btn-primary col-auto gap-2" href="{{ url()->previous() }}">
                 <span class="button-text">@lang('home.back')
                     <i class="feather-skip-back"></i>
                 </span>
             </a>
        </div>
    </div>
</body>

</html>
