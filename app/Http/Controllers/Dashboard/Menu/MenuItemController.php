<?php

namespace App\Http\Controllers\Dashboard\Menu;

use App\DataTables\Menu\MenuItemDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Menus\MenuItemRequest;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Menu\MenuItem;
use App\Models\Dashboard\Page\Page;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Service\Service;
use App\Services\Dashboard\Menu\MenuItemService;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    protected $menuItemService;

    public function __construct(MenuItemService $menuItemService)
    {
        $this->menuItemService = $menuItemService;

        $this->middleware('can:menu_items.read')->only('index');
        $this->middleware('can:menu_items.create')->only('store');
        $this->middleware('can:menu_items.update')->only('update');
        $this->middleware('can:menu_items.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(MenuItemDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.MenuItems.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        [$menus,$menuTypes,$menuItems] =$this->menuItemService->create();
        return view('Dashboard.MenuItems.create',compact('menus','menuTypes','menuItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuItemRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->menuItemService->store($dataValidated);

            return redirect()->route('menu-items.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(MenuItem $menuItem)
    {
        [$menus,$menuTypes,$type,$menuItems] =$this->menuItemService->edit($menuItem);
        $values =  $this->getMenuTypesValues($type);
        return view('Dashboard.MenuItems.edit',compact('menus','menuTypes','menuItem','type','values','menuItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuItemRequest $request, MenuItem $menuItem)
    {
        try {
            $dataValidated = $request->validated();

            $this->menuItemService->update($request, $dataValidated, $menuItem);

            return redirect()->route('menu-items.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:menu_items,id']
        ]);

        $deleted = $this->menuItemService->deleteMenuItem($selectedIds);

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

    public function getMenuTypeValues(){
        $type = $_POST['type'];

        if ($type == 'main-item') {
            return response()->json([
                'html' => ''
            ]);
        } elseif ($type == 'link') {
            return response()->json([
                'html' => view('Dashboard.MenuItems.type_values', compact('type'))->render()
            ]);
        } else {
            $values = $this->getMenuTypesValues($type);
            return response()->json([
                'html' => view('Dashboard.MenuItems.type_values', compact('values', 'type'))->render(),
            ]);
        }
    }

    public function getMenuTypesValues($type){
        $values = [];

        if($type == 'blog'){
            $values = Blog::select('id','name')->get();
        }

        if($type == 'service'){
            $values = Service::select('id','name')->get();
        }

        if($type == 'project'){
            $values = Project::select('id','name')->get();
        }

        if($type == 'page'){
            $values = page::select('id','name')->get();
        }

        if($type == 'blog-category'){
            $values = BlogCategory::select('id','name')->get();
        }
        // add here any new model you want//

        return $values;
    }

      public function updateOrder(Request $request)
    {
        try {
            $order = $request->input('order');

            foreach ($order as $item) {
                MenuItem::where('id', $item['id'])
                    ->update(['order' => $item['order']]);
            }

            return response()->json(['success' => true, 'message' => __('dash.order_updated_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => __('dash.error_updating_order')], 500);
        }
    }

}
