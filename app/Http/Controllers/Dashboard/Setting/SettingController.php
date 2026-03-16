<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\SettingRequest;

use App\Models\Dashboard\Setting\HomepageSection;
use App\Models\Dashboard\Setting\Setting;
use App\Services\Dashboard\Setting\SettingService;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;

        $this->middleware('can:general_settings.read')->only('index');
        $this->middleware('can:general_settings.update')->only('update');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $settings = Setting::firstOrFail();
        $sms_providers = Setting::SMSPROVIDERS;
        return view('Dashboard.Settings.edit', compact('settings','sms_providers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $general_setting = Setting::firstOrFail();
            $this->settingService->update($request, $dataValidated, $general_setting);

            return redirect()->back()->with(['success' => __('dash.settings_updated')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function getHomeSections(){
        $homePageSections = HomePageSection::orderBy('order','ASC')->get();
        return view('Dashboard.Settings.edit-home-sections', compact('homePageSections'));
    }



    public function updateSectionOrder(Request $request){
        $orderedSections = json_decode($request->input('orderedSections'), true);
        foreach ($orderedSections as $index => $sectionId) {
            HomePageSection::where('id', $sectionId)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

public function createQRCode()
{
    $logoPath = public_path('uploads/settings/' . (Setting::first()->logo ?? ''));
    $title = 'Scan to visit our site';
    $appUrl = env('APP_URL', 'https://example.com');

    // Build QR
    $qrCode = new QrCode(
        $appUrl,
        new Encoding('UTF-8'),
        ErrorCorrectionLevel::High,
        300,
        10,
        RoundBlockSizeMode::Margin,
        new Color(0, 0, 0),
        new Color(255, 255, 255)
    );

    $label = new Label($title);
    $logo = file_exists($logoPath) ? new Logo($logoPath, 80) : null;

    $writer = new PngWriter();
    $result = $writer->write($qrCode,  $logo,  $label);
    $fileName = 'qrcode_' . time() . '.png';
    Storage::disk('public')->put('uploads/qrcodes/' . $fileName, $result->getString());

    $url = asset('uploads/qrcodes/' . $fileName);
    return response()->json([
        'url' => $url,
        'message' => __('dash.QR code generated successfully'),
    ]);
}
}
