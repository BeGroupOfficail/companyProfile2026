<?php

namespace App\Http\Controllers\Dashboard\Section;

use App\DataTables\Section\SectionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sections\SectionRequest;
use App\Models\Dashboard\Sections\CompanySection;
use App\Services\Dashboard\Section\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;

        $this->middleware('can:sections.read')->only('index');
        $this->middleware('can:sections.create')->only('store', 'create');
        $this->middleware('can:sections.update')->only('update', 'edit');
        $this->middleware('can:sections.delete')->only('destroy');
    }

    public function index(SectionsDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.sections.index');
    }

    public function create()
    {
        return view('Dashboard.sections.create');
    }

    public function store(SectionRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->sectionService->store($dataValidated);
            return redirect()->route('sections.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit(CompanySection $section)
    {
        return view('Dashboard.sections.edit', compact('section'));
    }

    public function update(SectionRequest $request, CompanySection $section)
    {
        try {
            $dataValidated = $request->validated();
            $this->sectionService->update($request, $dataValidated, $section);
            return redirect()->route('sections.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:company_sections,id']
        ]);

        $deleted = $this->sectionService->deleteSection($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => __('messages.an error has occurred')], 422);
            }
            return response()->json(['success' => true, 'message' => trans('messages.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors(__('messages.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }
}
