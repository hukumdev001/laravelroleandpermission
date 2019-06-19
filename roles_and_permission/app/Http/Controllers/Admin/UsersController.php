<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if(! Gate::allows('users_manage')) {
            return abort(401);
        }

        $users = User::all();
        $pageName = 'Users';

        return view('admin.users.index', compact('users', 'pageName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if(! Gate::allows('users_manage')) {
            return abort(401);
        }
        $roles = Role::get()->pluck('name', 'name');

        $pageName = 'Add User';

        return view('admin.users.create', compact('roles', 'pageName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         if(! Gate::allows('users_manage')) {
            return abort(401);
        }

        $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|max:20|unique:users,username',
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
            'roles' => 'required|exits:roles,name',

        ]);


        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->admin_unique_key = $this->random_str(60);
        $user->save();

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
        return redirect()->route('admin::users.index')->with(['success' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(! Gate::allows('users_manage'))
        {
            return abort(401);
        }

        $roles = Role::get()->pluck('name', 'name');

        $user = User::findOrFail($id);

        $pageName = 'Edit Users';

        return view('admin.users.edit', compact('user', 'roles', 'pageName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(! Gate::allows('users_manage'))
        {
            return abort(401);
        }
        $request->validate([
            'name' => 'required|max:50',
            'username' => 'required|max:20|unique:users,username,'.$id;
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
            'roles' => 'required|exists:roles,name',

        ]);


        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);
        return redirect()->route('admin::user.index')->with(['success' => 'User updated successfully']);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(! Gate::allows('users_manage')) {
            return abort(401);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin::users.index')->with(['success' => 'User deleted successfully']);
    }



    public function massDestroy(Request $request) 
    {
        if(! Gate::allows('users_manage'))
        {
            return abort(401);
        }

        if($request->input('ids')) 
            {
                $entries = User::User::whereIn('id', $request->input('ids'))->get();
                foreach($entries as $entry){
                    $entry->delete();
                }
            }
    }

    protected function _random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit')-1;
        for($i = 0; $i<$length; ++$i) {
            $str .= $keyspace[random_int(0,$max)];
        }
        return $str;
    }
}
