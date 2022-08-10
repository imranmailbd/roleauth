<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Http\Controllers\Controller;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UsersController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    // public function create() 
    // {
    //     return view('users.create');
    // }

    public function create()
    {
    $roles = Role::pluck('name','name')->all();
    // dd($roles);
    return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request) 
    {
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $user->create(array_merge($request->validated(), [
            'password' => 'test' 
        ]));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }
    // public function store(Request $request)
    // {
    // $this->validate($request, [
    // 'name' => 'required',
    // 'email' => 'required|email|unique:users,email',
    // 'password' => 'required|same:confirm-password',
    // 'roles' => 'required'
    // ]);
    // $input = $request->all();
    // $input['password'] = Hash::make($input['password']);
    // $user = User::create($input);
    // $user->assignRole($request->input('roles'));
    // return redirect()->route('users.index')
    // ->with('success','User created successfully');
    // }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    // public function show(User $user) 
    // {
    //     return view('users.show', [
    //         'user' => $user
    //     ]);
    // }

    public function show($id)
    {
    $user = User::find($id);
    return view('users.show',compact('user'));
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request) 
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) 
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}