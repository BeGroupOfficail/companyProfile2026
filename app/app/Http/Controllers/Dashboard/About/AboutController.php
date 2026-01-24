<?php

namespace App\Http\Controllers\Dashboard\About;

use App\Models\Dashboard\About\AboutUs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\About\AboutRequest;
use App\Services\Dashboard\About\AboutService;

class AboutController extends Controller
{
    protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->aboutService = $aboutService;

        $this->middleware('can:about_us.read')->only('edit');
        $this->middleware('can:about_us.update')->only('update');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $about = AboutUs::firstOrFail();
        return view('Dashboard.About.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $about = AboutUs::firstOrFail();
            $this->aboutService->update($dataValidated, $about);

            return redirect()->back()->with(['success' => __('dash.settings_updated')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

}
