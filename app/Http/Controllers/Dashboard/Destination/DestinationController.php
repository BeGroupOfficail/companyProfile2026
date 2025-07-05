<?php

namespace App\Http\Controllers\Dashboard\Destination;

use App\DataTables\Destination\DestinationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Destination\DestinationRequest;
use App\Models\Dashboard\Destination\Destination;
use App\Services\Dashboard\Destination\DestinationService;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;

        $this->middleware('can:destinations.read')->only('index');
        $this->middleware('can:destinations.create')->only('store');
        $this->middleware('can:destinations.update')->only('update');
        $this->middleware('can:destinations.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(DestinationDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Destinations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = $this->destinationService->create();
        return view('Dashboard.Destinations.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DestinationRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->destinationService->store($dataValidated);

            return redirect()->route('destinations.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Destination $destination)
    {
        [$countries,$regions] = $this->destinationService->edit($destination);
        return view('Dashboard.Destinations.edit', compact('destination','countries','regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DestinationRequest $request, Destination $destination)
    {
        try {
            $dataValidated = $request->validated();

            $this->destinationService->update($request, $dataValidated, $destination);

            return redirect()->route('destinations.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:destinations,id']
        ]);

        $deleted = $this->destinationService->deleteDestinations($selectedIds);

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
