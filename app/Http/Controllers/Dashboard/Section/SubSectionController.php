<?php

namespace App\Http\Controllers\Dashboard\Section;

use App\DataTables\Section\SubSectionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sections\SubSectionRequest;
use App\Models\Dashboard\Sections\CompanySection;
use App\Models\Dashboard\Sections\CompanySubSection;
use App\Services\Dashboard\Section\SubSectionService;
use Illuminate\Http\Request;

class SubSectionController extends Controller
{
    protected $subSectionService;

    public function __construct(SubSectionService $subSectionService)
    {
        $this->subSectionService = $subSectionService;

        $this->middleware('can:sections.read')->only('index');
        $this->middleware('can:sections.create')->only('store', 'create');
        $this->middleware('can:sections.update')->only('update', 'edit');
        $this->middleware('can:sections.delete')->only('destroy');
    }

    public function index(SubSectionsDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.sub_sections.index');
    }

    public function create()
    {
        $sections = CompanySection::all();
        return view('Dashboard.sub_sections.create', compact('sections'));
    }

    public function store(SubSectionRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->subSectionService->store($dataValidated);
            return redirect()->route('sub-sections.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit(CompanySubSection $subSection)
    {
        $sections = CompanySection::all();
        return view('Dashboard.sub_sections.edit', compact('subSection', 'sections'));
    }

    public function update(SubSectionRequest $request, CompanySubSection $subSection)
    {
        try {
            $dataValidated = $request->validated();
            $this->subSectionService->update($request, $dataValidated, $subSection);
            return redirect()->route('sub-sections.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:company_sub_sections,id']
        ]);

        $deleted = $this->subSectionService->deleteSubSection($selectedIds);

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
