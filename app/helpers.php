<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin\Modules;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Auth;


function getCurrentServerDate()
{
    return Carbon::now()->toDateString();
}

function getCurrentServerDateTime()
{
    return Carbon::now()->format('Y-m-d H:i:s');
}

function dateWithTime($date)
{
    $currentTime = Carbon::now()->format('H:i:s');

    return $date . ' ' . $currentTime;
}
function getModulesWithChildModules()
{
    return Modules::orderBy('order')->get();;
}

function getUserPermissionModules()
{
    $user = Auth::user();
    $userPermission = Role::where('id', $user->role_id)->pluck('permissions')->first();
    $modules = Modules::whereIn('id',  $userPermission)->orderBy('order','ASC')->get();

    return $modules;
}
