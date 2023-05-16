<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\UserStoreRequest;
use App\Http\Requests\dashboard\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // middleware permissions
    public function __construct()
    {
        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:create_users')->only('create');
        $this->middleware('permission:update_users')->only('edit');
        $this->middleware('permission:delete_users')->only('destroy');
    }


    public function index(Request $request)
    {
        $users = User::whereHasRole('admin')->when($request->search, function ($q) use ($request) {
            return $q->where('first_name', 'like', '%' . $request->search . '%')
                ->orWhere('last_name', 'like', '%' . $request->search . '%');
        })->whereHasRole('admin')->latest()->paginate(5);
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(UserStoreRequest $request)
    {
        // validate on request
        // prepare data
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        // inser in db
        $user = User::create($data);
        $user->addRole('admin');
        $user->syncPermissions($request->permissions);
        // succeess msg
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        // validate on request
        // prepare data
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ];

        // inser in db
        $user->update($data);
        // update permissions
        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        } else {
            $user->syncPermissions([]);
        }
        // succeess msg
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
