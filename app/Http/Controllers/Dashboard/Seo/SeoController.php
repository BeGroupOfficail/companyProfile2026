<?php

namespace App\Http\Controllers\Dashboard\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Seo\SeoRequest;
use App\Models\Dashboard\Seo\Seo;
use App\Services\Dashboard\Seo\SeoService;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;

        $this->middleware('can:seo.read')->only('edit');
        $this->middleware('can:seo.update')->only('update');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id){
        [$seo , $pageTypes,$schmeaTypes] = $this->seoService->edit($id);
        return view('Dashboard.Seo.edit', compact('seo','pageTypes','schmeaTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeoRequest $request,$pageType)
    {
        try {
            $dataValidated = $request->validated();
            $seo = Seo::where('page_type',$pageType)->first();
            $this->seoService->update($dataValidated, $seo);

            return redirect()->back()->with(['success' => __('dash.settings_updated')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
