<?php

namespace App\Http\Controllers\Admin\UserGroup;

use stdClass;
use Illuminate\Http\Request;
use App\Models\Admin\Modules;
use App\Models\Admin\UserGroup;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class UserGroupsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allModules = Modules::select('id', 'name', 'parent_id')->get();

        return view('Admin.user-groups.index', [
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

            $userGroup = new UserGroup();

            $userGroup->name = $request->name;

            $userGroup->save();

            return response()->json(['message' => 'User Group added successfully','userGroup' =>$userGroup ], 201);
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
            $userGroup = UserGroup::findOrFail($id);
            return response()->json($userGroup, 200);
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
            $userGroup = UserGroup::findOrFail($id);

            $userGroup->name = $request->name;

            $userGroup->save();

            return response()->json(['message' => 'User Group updated successfully','userGroup' =>$userGroup], 200);
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
            $data = UserGroup::select('id', 'name','is_active')
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
            UserGroup::whereId($id)->update([
                'is_active' => $request->status
            ]);

            return response()->json(['message' => 'User Group status updated successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function updateUserPermissions(Request $request,$groupId){
        try {

            $userGroup=UserGroup::findOrFail($groupId);
            $userGroup->assigned_modules = $request->selectedModules; // Encode as JSON
            $userGroup->save();
            return response()->json(['message' => 'User Group Permission updated successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    public function saveUserPermissions(Request $request){
        try {
            // dd($request->all());
            $userGroup=UserGroup::findOrFail($request->name);
            $userGroup->assigned_modules = $request->selectedModules; // Encode as JSON
            $userGroup->save();
            return response()->json(['message' => 'User Group Permission updated successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
