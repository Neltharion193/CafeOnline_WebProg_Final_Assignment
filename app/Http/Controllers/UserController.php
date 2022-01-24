<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function viewLogin(){
        return view("login");
    }

    public function viewChangePassword(){
        return view("changePassword");
    }

    public function viewRegister(){
        return view("register");
    }

    public function viewHome(){
        return view("home");
    }

    public function viewRegisterStaff(){
        return view("createStaffAccount");
    }

    public function validateLogin(Request $req){
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $user = DB::table('ms_users')
                    ->where('email', $req->email)->get();

        if($user->isEmpty() || !Hash::check($req->password, $user[0]->password)){
            return back()->withInput()->withErrors('email or password is invalid!');
        }

        $user = [
            'id' => $user[0]->id,
            'user_type_id' => $user[0]->user_type_id,
            'fullname' => $user[0]->fullname,
            'email' => $user[0]->email,
            'password' => $req->password,
            'address' => $user[0]->address,
            'gender' => $user[0]->gender
        ];

        if(Auth::attempt($user)){
            session()->put('usersession', $user);
        }

        return redirect('/home')->with('message', 'Successfully Login!');
    }

    public function logout() {
        Auth::logout();

        session()->forget('usersession');

        return redirect('login')->with('message', 'Successfully Logout!');
    }

    public function changePassword(Request $req){
        $rules = [
            'email' => 'required',
            'oldPassword' => 'required',
            'newPassword' => 'required|min:3',
            'confPassword' => 'required|same:newPassword',
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $user = DB::table('ms_users')
                    ->where('email', $req->email)->get();

        if($user->isEmpty() || !Hash::check($req->oldPassword, $user[0]->password)){
            return back()->withInput()->withErrors('email or old password is incorrect');
        }

        else{
            $newPassword = Hash::make($req->newPassword);
    
            DB::table('ms_users')
                ->where('email', $req->email)
                ->update(['password' => $newPassword]);
        }

        return redirect('/login')->with('message', 'Successfully Change Password!');
    }

    public function registerCustomer(Request $req){
        $rules = [
            'fullname' => 'required|min:5',
            'email' => 'required|email|unique:ms_users',
            'password' => 'required|min:3',
            'confPassword' => 'required|same:password',
            'address' => 'required|min:5'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $user = new MsUser();
        $user->user_type_id = 3;
        $user->fullname = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->address = $req->address;
        $user->gender = $req->gender;
        $user->timestamps = false;

        $user->save();

        return redirect('/login')->with('message', 'Successfully Create Account!');
    }

    public function createStaff(Request $req){
        $rules = [
            'fullname' => 'required|min:5',
            'email' => 'required|email|unique:ms_users',
            'password' => 'required|min:3',
            'confPassword' => 'required|same:password',
            'address' => 'required|min:5'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        $user = new MsUser();
        $user->user_type_id = 2;
        $user->fullname = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->address = $req->address;
        $user->gender = $req->gender;
        $user->timestamps = false;

        $user->save();

        return redirect('/home')->with('message', 'Successfully Create Staff Account!');
    }
}
