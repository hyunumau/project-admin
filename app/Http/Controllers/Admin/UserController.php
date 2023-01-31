<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    protected $userService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $this->authorize('can_do', ['user read']);

            $filter = [
                ...$request->query(),
                'filter' => [
                    'is_superadmin' => 0
                ],
                'paginate' => 10
            ];

        $users = $this->userService->getList($filter);

        return view('admin.user.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $this->authorize('can_do', ['user create']);

        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('can_do', ['user create']);

        $this->userService->create($request->validated());

        return redirect()->route('user.index')
            ->with('message', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('can_do', ['user read']);

        $roles = Role::all();
        $userRoles = array_column(json_decode($user->roles, true), 'id');

        return view('admin.user.show', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('can_do', ['user edit']);

        $roles = Role::all();
        $userHasRoles = array_column(json_decode($user->roles, true), 'id');

        return view('admin.user.edit', compact('user', 'roles', 'userHasRoles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('can_do', ['user edit']);

        $this->userService->update($request->validated(), $user);
        
        return redirect()->route('user.index')
            ->with('message', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('can_do', ['user delete']);

        $user->delete();

        return redirect()->route('user.index')
            ->with('message', 'User deleted successfully');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $roles = Role::all();
        $userRoles = array_column(json_decode($user->roles, true), 'id');
        
        return view('dashboard', compact('user', 'roles', 'userRoles'));
    }
}
