<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin\User;
use Illuminate\Http\Request;
use App\Models\Admin\UserGroup;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Google\Service\CloudSourceRepositories\Repo;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    // login
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user =  Auth::user();

            if ($user->is_active == 1) {

                $assignedModulesToUser = UserGroup::where('id', $user->role_id)->pluck('assigned_modules')->first();

                User::whereId(Auth::id())->update([
                    'last_login' => Carbon::now(),
                    'last_ip' => $request->getClientIp()
                ]);

                if ($assignedModulesToUser && in_array(1, $assignedModulesToUser)) {
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('afterLogin');
                }

            } else {
                return redirect()->back()->withErrors(['error' => 'You are not authorized to login.']);
            }
        }
        return redirect()->back()->withErrors(['error' => 'Email or Password is wrong']);
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login-page')->with('message', 'Logout Successfully');
    }

    // change password page
    public function changePasswordPage()
    {
        return view('change-password');
    }
    // Check password
    public function checkPassword(Request $request)
    {
        if (Hash::check($request->old_password, Auth::user()->getAuthPassword())) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // update password
    public function updatePassword(Request $request)
    {
        try {
            if (Hash::needsRehash($request->password)) {
                User::whereId(Auth::id())->update([
                    'password' => Hash::make($request->password)
                ]);
                Auth::logout();
            }

            return response()->json(['message' => 'Password updated successfully']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function userProfilePage(){
        return view('Admin.users.user-profile');
    }

    public function afterLogin(){
        return view('after_login');
    }

    public function userProfileUpdate(Request $request){
        try {
            User::where('id',$request->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile' => $request->mobile,
            ]);

            return response()->json(['message' => 'Profile updated successfully'],200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
