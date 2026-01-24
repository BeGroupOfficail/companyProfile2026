<?php

namespace App\Http\Controllers\Dashboard\Page;

use App\DataTables\Page\PageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Pages\PageRequest;
use App\Models\Dashboard\Page\Page;
use App\Services\Dashboard\Page\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;

        $this->middleware('can:pages.read')->only('index');
        $this->middleware('can:pages.create')->only('store');
        $this->middleware('can:pages.update')->only('update');
        $this->middleware('can:pages.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PageDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pages = $this->pageService->create();
        return view('Dashboard.Pages.create', compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->pageService->store($dataValidated);

            return redirect()->route('pages.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Page $page)
    {
        return view('Dashboard.Pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request, Page $page)
    {
        try {
            $dataValidated = $request->validated();

            $this->pageService->update($request, $dataValidated, $page);

            return redirect()->route('pages.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:pages,id']
        ]);

        $deleted = $this->pageService->deletePages($selectedIds);

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
