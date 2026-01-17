<?php

namespace App\Http\Controllers\Dashboard\Service;

use App\DataTables\Service\ServiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Service\ServiceRequest;
use App\Models\Dashboard\Service\Service;
use App\Services\Dashboard\Service\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;

        $this->middleware('can:services.read')->only('index');
        $this->middleware('can:services.create')->only('store');
        $this->middleware('can:services.update')->only('update');
        $this->middleware('can:services.delete')->only('destroy');
    }

    public function index(ServiceDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $service_parents = $this->serviceService->create();
        return view('Dashboard.Services.create', compact('service_parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->serviceService->store($dataValidated);
            return redirect()->route('services.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $service_parents = $this->serviceService->edit($service);
        return view('Dashboard.Services.edit', compact('service', 'service_parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {
        // dd($request->all());
        try {
            $dataValidated = $request->validated();
            $this->serviceService->update($request, $dataValidated,  $service);

            return redirect()->route('services.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
            'selectedIds.*' => ['exists:services,id']
        ]);

        $deleted = $this->serviceService->deleteServices($selectedIds);

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
