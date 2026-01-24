<?php

namespace App\Http\Controllers\Dashboard\About;

use App\DataTables\About\AboutValueDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\About\AboutValueRequest;
use App\Models\Dashboard\About\AboutValue;
use App\Services\Dashboard\About\AboutValueService;
use Illuminate\Http\Request;

class AboutValueController extends Controller
{
    protected $aboutValueService;

    public function __construct(AboutValueService $aboutValueService)
    {
        $this->aboutValueService = $aboutValueService;

        $this->middleware('can:about_values.read')->only('index');
        $this->middleware('can:about_values.create')->only('store');
        $this->middleware('can:about_values.update')->only('update');
        $this->middleware('can:about_values.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AboutValueDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.AboutValues.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = $this->aboutValueService->create();
        return view('Dashboard.AboutValues.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutValueRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->aboutValueService->store($dataValidated);

            return redirect()->route('about-values.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(AboutValue $aboutValue)
    {
        $types = $this->aboutValueService->edit();
        return view('Dashboard.AboutValues.edit',compact('aboutValue','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutValueRequest $request, AboutValue $aboutValue)
    {
        try {
            $dataValidated = $request->validated();

            $this->aboutValueService->update($request, $dataValidated, $aboutValue);

            return redirect()->route('about-values.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:about_values,id']
        ]);

        $deleted = $this->aboutValueService->deleteAboutValues($selectedIds);

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
