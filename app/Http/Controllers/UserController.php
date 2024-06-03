<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HistoryLog;
Use File;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Users List';
        $data['breadcumb'] = 'Users List';
        $data['users'] = User::orderby('id', 'asc')->get();
        $data['roles'] = Role::pluck('name')->all();

        return view('master-data.user.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add User';
        $data['breadcumb'] = 'Add';
        $data['roles'] = Role::pluck('name')->all();

        return view('master-data.user.create', $data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'role' => 'required',
        ]);

        try {
            $user = new User();
            $user->name = $validateData['name'];
            // $user->username = $validateData['username'];
            $user->email = $validateData['email'];
            $user->password = Hash::make($validateData['password']);

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('assets/images/user/');
                $image->move($destinationPath, $name);
                $user->avatar = $name;
            }

            $user->save();
            $user->assignRole($validateData['role']);

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Add';
            $newHistoryLog->menu = 'Add User '.$user->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('master-data.users.index')->with(['success' => 'User added successfully!']);
        } catch (\Throwable $th) {
            // dd($th);
            // return redirect()->back()->with(['failed' => 'User added Failed!']);
            return redirect()->back()->with(['failed' => $th->getMessage()]);
        }
        
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit User';
        $data['breadcumb'] = 'Edit';
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::pluck('name')->all();

        return view('master-data.user.edit', $data);
    }

    public function userProfile($id)
    {
        $data['page_title'] = 'Edit User';
        $data['breadcumb'] = 'Edit';
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::pluck('name')->all();

        return view('master-data.user.profile', $data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            // 'username'   => 'required|alpha_dash|unique:users,username,'.$id,
            'email'   => 'required|unique:users,email,'.$id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('assets/images/user/');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        $user->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($validateData['role']);

        $newHistoryLog = new HistoryLog();
        $newHistoryLog->datetime = date('Y-m-d H:i:s');
        $newHistoryLog->type = 'Edit';
        $newHistoryLog->menu = 'Edit User '.$user->name;
        $newHistoryLog->user_id = auth()->user()->id;
        $newHistoryLog->save();

        return redirect()->back()->with(['success' => 'User edited successfully!']);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            $user->historyLogs()->delete();
            $user->delete();

            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Delete';
            $newHistoryLog->menu = 'Delete User '.$user->name;
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();
        });
        
        
        Session::flash('success', 'User deleted successfully!');
        return response()->json(['status' => '200']);
    }

    public function show(){
        
    }

    public function profile($id)
    {
        $data['page_title'] = 'Edit Profile';
        $data['breadcumb'] = 'Edit';
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::pluck('name')->all();

        return view('master-data.user.profile', $data);
    }
    public function changePassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($validateData['password'], $user->password)) {
            $user->password = Hash::make($request->get('new_password'));
            $user->save();
            
            $newHistoryLog = new HistoryLog();
            $newHistoryLog->datetime = date('Y-m-d H:i:s');
            $newHistoryLog->type = 'Change Password';
            $newHistoryLog->user_id = auth()->user()->id;
            $newHistoryLog->save();

            return redirect()->route('backend.users.edit', Auth::user()->id)->with('success', 'Password changed successfully!');
        } else {
            return redirect()->route('backend.users.edit', Auth::user()->id)->with('failed', 'Password change failed');
        }
    }
}
