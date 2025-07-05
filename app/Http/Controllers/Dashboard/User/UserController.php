<?php

namespace App\Http\Controllers\Dashboard\User;
use App\DataTables\User\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\User\StoreUserRequest;
use App\Http\Requests\Dashboard\User\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Dashboard\User\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->middleware('can:users.read')->only('index');
        $this->middleware('can:users.create')->only('store');
        $this->middleware('can:users.update')->only('update');
        $this->middleware('can:users.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request$request , UserDataTable $dataTable)
    {
        $type = $request->input('type');
        if ($type) {
            $dataTable->setType($type);
        }

        return $dataTable->render('Dashboard.Users.Users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        [$job_roles,$roles] = $this->userService->create();
        return view('Dashboard.Users.Users.create', compact('job_roles','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeUserRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->userService->store($dataValidated);

            return redirect()->route('users.users.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(User $user)
    {
        [$job_roles,$roles,$userRoles] = $this->userService->edit($user);
        return view('Dashboard.Users.Users.edit', compact('user','roles','job_roles','userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $dataValidated = $request->validated();

            $this->userService->update($request, $dataValidated, $user);

            return redirect()->route('users.users.index',['type'=>$request->type])->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:users,id','not_in:1']
        ]);

        $deleted = $this->userService->deleteUsers($selectedIds);

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
