<?php

namespace App\Http\Controllers\Dashboard\Menu;

use App\DataTables\Menu\MenuDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Menus\MenuRequest;
use App\Models\Dashboard\Menu\Menu;
use App\Services\Dashboard\Menu\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;

        $this->middleware('can:menus.read')->only('index');
        $this->middleware('can:menus.create')->only('store');
        $this->middleware('can:menus.update')->only('update');
        $this->middleware('can:menus.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(MenuDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Menus.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->menuService->create();
        return view('Dashboard.Menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->menuService->store($dataValidated);

            return redirect()->route('menus.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Menu $menu)
    {
        return view('Dashboard.Menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        try {
            $dataValidated = $request->validated();

            $this->menuService->update($request, $dataValidated, $menu);

            return redirect()->route('menus.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:menus,id']
        ]);

        $deleted = $this->menuService->deleteMenu($selectedIds);

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
