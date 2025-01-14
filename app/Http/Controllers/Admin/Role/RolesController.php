<?php

namespace App\Http\Controllers\Admin\Role;

use stdClass;
use Illuminate\Http\Request;
use App\Models\Admin\Modules;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Models\Admin\Role;

class RolesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allModules = Modules::select('id', 'name', 'parent_id')->get();

        return view('Admin.roles.index', [
            'all_modules' => $allModules
        ]);
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

            $role = new Role();

            $role->name = $request->name;

            $role->save();

            return response()->json(['message' => 'Role added successfully','role' =>$role ], 201);
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
            $role = Role::findOrFail($id);
            return response()->json($role, 200);
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
            $role = Role::findOrFail($id);

            $role->name = $request->name;

            $role->save();

            return response()->json(['message' => 'Role updated successfully','role' =>$role], 200);
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
        //
    }

    public function getServerData()
    {
        try {
            $data = Role::select('id', 'name','is_active')
            ->orderBy('name', 'asc')
            ->get();

            return response()->json($data, 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function getFormData()
    {
        try {
            $obj = new stdClass();
            $obj->allModules = Modules::select('id', 'name', 'parent_id')
            ->where('is_active', 1)
            ->get();

            return response()->json($obj, 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function updateIsActive(Request $request, $id)
    {
        try {
            Role::whereId($id)->update([
                'is_active' => $request->status
            ]);

            return response()->json(['message' => 'Role status updated successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function updateUserPermissions(Request $request,$groupId){
        try {

            $role=Role::findOrFail($groupId);
            $role->permissions = $request->permissions; // Encode as JSON
            $role->save();
            return response()->json(['message' => 'Role Permission updated successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function saveUserPermissions(Request $request){
        try {
            // dd($request->all());
            $role=Role::findOrFail($request->name);
            $role->permissions = $request->permissions; // Encode as JSON
            $role->save();
            return response()->json(['message' => 'Role Permission updated successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
