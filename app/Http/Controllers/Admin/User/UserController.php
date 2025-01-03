<?php

namespace App\Http\Controllers\Admin\User;


use App\Models\Admin\User;
use Illuminate\Http\Request;
use App\Models\Admin\UserGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user=new User();

            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            $user->access_key=md5($request->email . '.' . $request->password );
            $user->password = bcrypt($request->password);
            $user->readable_password = $request->password;
            $user->role_id = $request->role_id;
            $user->mobile = $request->mobile;

            $user->save();
            $user->load('userGroup');
            return response()->json(["message"=> "User Added Successfully",'user' => $user]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
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
        try {
            $password = null;
            if(Auth::user()->role_id ==1){
                $password = DB::table('users')->where('id',$id)->pluck('readable_password')->first();
            }
            $user=User::findOrFail($id);
            return response()->json(['user'=>$user,'password'=> $password]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
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
        try {
            $user=User::findOrFail($id);

            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            $user->access_key=md5($request->email . '.' . $request->password );
            if(Auth::user()->role_id == 1){
                $user->password = bcrypt($request->password);
                $user->readable_password = $request->password;
            }
            $user->role_id = $request->role_id;
            $user->mobile = $request->mobile;
            $user->save();
            $user->load('userGroup');
            return response()->json(["message"=> "User Updated Successfully",'user'=>$user]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User Deleted Successfully']);
    }


    public function getUsers(){
        try {
            $users=User::select('id','role_id','first_name','last_name','email','is_active')
                ->with('userGroup')
                ->where('is_active',1)->get();
            // dd($users);
            return response()->json($users);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function getUserGroups(){

        try {
            $userGroups=UserGroup::where('is_active',1)
                ->select('id','name')
                ->get();
            return response()->json($userGroups);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }
}
