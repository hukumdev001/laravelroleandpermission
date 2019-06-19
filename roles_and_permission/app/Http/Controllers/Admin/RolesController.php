<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class RolesController extends Controller
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

        $roles = Role::all();
        $pageName = 'Roles';

        return view('admin.roles.index', compact('roles', 'pageName'));
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

        $permissions = Permission::get()->pluck('name', 'name');

        $pageName = 'Add Roles';

        return view('admin.roles.create', compact('permissions', 'pageName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(! Gate::allow('users_manage')) {
            return abort(401);
        }

        $request->validate([
            'name' => 'required|max:50',
            'permission' => 'required|exits:permissions,name',

        ]);

        $role = Role::create($request->except('permission'));

        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);

        return redirect()->route('admin:roles.index')->with(['success' => 'Role created successfully']);
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
        if(! Gate::allows('users_manage')) {
            return abort(401);
        }

        $permissions = Permission::get()->pluck('name', 'name');
        $pageName = 'Edit Roles';

        $role = Role::findOrfail($id);

        return view('admin.roles.edit', compact('role', 'permissions', 'pageName'));
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
        if (! Gate::allow('users_manage')) {
            return abort(401);
        }

        $request->validate([
            'name' => 'required|max:50',
            'permission' => 'required|exits:permissions,name',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->expect('permission'));
        $permission = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermission($permissions);

        return redirect()->route('admin::roles.index')->with(['success' => 'Role updated successfully']);
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

        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin::roles.index')->with(['success' => 'Role deleted successfullly']);
    }


    public function massDestroy(Request $request)
    {
        if(! Gate::allows('users_manage')) {
            return abort(401);
        }

        if($request->input('ids')) {

            $entries = Role::whereIn('id', $request->input('ids'))->get();

            foreach($entries as $entry) {
                $entry->delete();
            }
        }
    }
}
