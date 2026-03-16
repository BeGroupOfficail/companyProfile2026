<?php

namespace App\Http\Controllers\Dashboard\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Seo\CompanySeoRequest;
use App\Services\Dashboard\Seo\CompanySeoService;

class CompanySeoController extends Controller
{
    protected $companySeoService;

    public function __construct(CompanySeoService $companySeoService)
    {
        $this->companySeoService = $companySeoService;
    }

    public function edit()
    {
        $companySeo = $this->companySeoService->getSeo();
        return view('Dashboard.Seo.company_seo.edit', compact('companySeo'));
    }

    public function update(CompanySeoRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->companySeoService->updateSeo($dataValidated);

            return redirect()->back()->with(['success' => __('dash.settings_updated') ?? 'Settings updated successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
