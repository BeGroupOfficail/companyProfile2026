<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\SettingRequest;
use App\Models\Dashboard\Setting\HomepageSection;
use App\Models\Dashboard\Setting\Setting;
use App\Models\Dashboard\Setting\WebsiteDesign;
use App\Services\Dashboard\Setting\SettingService;
use Illuminate\Http\Request;

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
        return view('Dashboard.Settings.edit', compact('settings'));
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

    public function getWebsiteDesign(){
        $websiteDesigns = WebsiteDesign::all();
        $homePageSections = HomePageSection::orderBy('order','ASC')->get();
        return view('Dashboard.Settings.edit-website-design', compact('websiteDesigns','homePageSections'));
    }

    public function updateWebsiteDesign(Request $request){
        try {
            $this->settingService->updateWebsiteDesign($request);

            return redirect()->back()->with(['success' => __('dash.website_design_updated')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function updateSectionOrder(Request $request){
        $orderedSections = json_decode($request->input('orderedSections'), true);
        foreach ($orderedSections as $index => $sectionId) {
            HomePageSection::where('id', $sectionId)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}
