<?php

namespace App\Http\Controllers\Dashboard\User;
use App\DataTables\User\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\Role\StoreRoleRequest;
use App\Http\Requests\Dashboard\User\Role\UpdateRoleRequest;
use App\Services\Dashboard\User\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;

        $this->middleware('can:roles.read')->only('index');
        $this->middleware('can:roles.create')->only('store');
        $this->middleware('can:roles.update')->only('update');
        $this->middleware('can:roles.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleService->index();
        return view('Dashboard.Users.Roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::whereNotLike('name', '%.%')->get();
        return view('Dashboard.Users.Roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->roleService->store($dataValidated);

            return redirect()->route('users.roles.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
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
    public function edit(Role $role)
    {
        $permissions = Permission::whereNotLike('name', '%.%')->get();
        $rolePermissions= $role->permissions()->pluck('name')->toArray();
        return view('Dashboard.Users.Roles.edit', compact('role','permissions','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $dataValidated = $request->validated();

            $this->roleService->update($request, $dataValidated, $role);

            return redirect()->route('users.roles.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $deleted = $this->roleService->deleteRole($id);

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
