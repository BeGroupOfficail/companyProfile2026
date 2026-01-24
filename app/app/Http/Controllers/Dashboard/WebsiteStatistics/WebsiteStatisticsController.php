<?php

namespace App\Http\Controllers\Dashboard\WebsiteStatistics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use App\DataTables\WebsiteStatistics\WebsiteStatisticsDataTable;
use App\Http\Requests\Dashboard\WebsiteStatistics\WebsiteStatisticsRequest;
use App\Services\Dashboard\WebsiteStatistics\WebsiteStatisticsService;

class WebsiteStatisticsController extends Controller
{
    protected $websiteStatisticsService;

    public function __construct(WebsiteStatisticsService $websiteStatisticsService)
    {
        $this->websiteStatisticsService = $websiteStatisticsService;

        $this->middleware('can:website_statistics.read')->only('index');
        $this->middleware('can:website_statistics.create')->only('store');
        $this->middleware('can:website_statistics.update')->only('update');
        $this->middleware('can:website_statistics.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(WebsiteStatisticsDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.WebsiteStatistics.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.WebsiteStatistics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WebsiteStatisticsRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->websiteStatisticsService->store($dataValidated);

            return redirect()->route('website-statistics.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteStatistics $websiteStatistic)
    {
        return view('Dashboard.WebsiteStatistics.edit', compact('websiteStatistic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WebsiteStatisticsRequest $request, WebsiteStatistics $websiteStatistic)
    {
        try {
            $dataValidated = $request->validated();

            $this->websiteStatisticsService->update($request, $dataValidated, $websiteStatistic);

            return redirect()->route('website-statistics.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:website_statistics,id']
        ]);

        $deleted = $this->websiteStatisticsService->deleteWebsiteStatistics($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('messages.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => trans('messages.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors($delete ?? __('messages.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }

}
