<?php

namespace App\Http\Controllers\Dashboard\User;
use App\DataTables\User\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\Permission\StorePermissionRequest;
use App\Http\Requests\Dashboard\User\Permission\updatePermissionRequest;
use App\Services\Dashboard\CategoryService;
use App\Services\Dashboard\User\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;

        $this->middleware('can:permissions.read')->only('index');
        $this->middleware('can:permissions.create')->only('store');
        $this->middleware('can:permissions.update')->only('update');
        $this->middleware('can:permissions.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Users.Permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Users.Permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->permissionService->store($dataValidated);
            return redirect()->route('users.permissions.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('messages.failed_to_add_item')]);
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
    public function edit(Permission $permission)
    {
        return view('Dashboard.Users.Permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updatePermissionRequest $request, Permission $permission)
    {
        try {

            $dataValidated = $request->validated();

            $this->permissionService->update($request, $dataValidated, $permission);

            return redirect()->route('users.permissions.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('messages.failed_to_update_item')]);
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
            'selectedIds.*' => ['exists:permissions,id']
        ]);

        $deleted = $this->permissionService->deletePermissions($selectedIds);

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
