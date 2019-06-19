<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    protected $redirectTo = 'admin/change_password';


    public function showChangePasswordFrom()
    {
    	$user = Auth::getUser();
    	$pageName = 'Change Password';

    	return view('admin.change_password', compact('user', 'pageName'));


    }


    public function changePassword(Request $request) 
    {
    	$user = Auth::getUser();
    	$this->validator($request->all())->validate();
    	if(Hash::check($request->get('current_password'), $user->password)) {
    		$user->password = Hash::make($request->get('new_password'));
    		$user->save();
    		return redirect($this->redirectTo)->with(['success' => 'Password changed successfully']);
     	} else {
     		return redirect()->back()->with(['danger' => 'Current password incorrect!']);
     	}
    }

    protected function validator(array $data)
    {
    	return Validator::make($data, [
    		'current_password' => 'required',
    		'new_password' => 'required|min:6|confirmed',

    	]);
    }

}
