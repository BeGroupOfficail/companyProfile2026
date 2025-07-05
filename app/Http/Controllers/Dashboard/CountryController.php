<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CountryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\CountryRequest;
use App\Models\Dashboard\Country;
use App\Services\Dashboard\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;

        $this->middleware('can:countries.read')->only('index');
        $this->middleware('can:countries.create')->only('store');
        $this->middleware('can:countries.update')->only('update');
        $this->middleware('can:countries.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Countries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->countryService->store($dataValidated);
            return redirect()->route('settings.countries.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('messages.failed_to_add_item')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('Dashboard.Countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(CountryRequest $request, Country $country)
    {
        $dataValidated = $request->validated();
        $this->countryService->update($dataValidated, $country);
        try {
            return redirect()->route('settings.countries.index')->with(['success' => __('messages.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('messages.failed_to_add_item')]);
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
            'selectedIds.*' => ['exists:countries,id']
        ]);
        $deleted = $this->countryService->delete($selectedIds);

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
