<?php

namespace App\Http\Controllers\Dashboard\Section;

use App\DataTables\Section\SubSectionItemsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sections\SubSectionItemRequest;
use App\Models\Dashboard\Sections\CompanySubSection;
use App\Models\Dashboard\Sections\CompanySubSectionItem;
use App\Services\Dashboard\Section\SubSectionItemService;
use Illuminate\Http\Request;

class SubSectionItemController extends Controller
{
    protected $subSectionItemService;

    public function __construct(SubSectionItemService $subSectionItemService)
    {
        $this->subSectionItemService = $subSectionItemService;

        $this->middleware('can:sections.read')->only('index');
        $this->middleware('can:sections.create')->only('store', 'create');
        $this->middleware('can:sections.update')->only('update', 'edit');
        $this->middleware('can:sections.delete')->only('destroy');
    }

    public function index(SubSectionItemsDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Sections.sub_section_items.index');
    }

    public function create()
    {
        $subSections = CompanySubSection::all();
        return view('Dashboard.Sections.sub_section_items.create', compact('subSections'));
    }

    public function store(SubSectionItemRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->subSectionItemService->store($dataValidated);
            return redirect()->route('sub-section-items.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit(CompanySubSectionItem $subSectionItem)
    {
        $subSections = CompanySubSection::all();
        return view('Dashboard.Sections.sub_section_items.edit', compact('subSectionItem', 'subSections'));
    }

    public function update(SubSectionItemRequest $request, CompanySubSectionItem $subSectionItem)
    {
        try {
            $dataValidated = $request->validated();
            $this->subSectionItemService->update($request, $dataValidated, $subSectionItem);
            return redirect()->route('sub-section-items.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:company_sub_section_items,id']
        ]);

        $deleted = $this->subSectionItemService->deleteItem($selectedIds);

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
