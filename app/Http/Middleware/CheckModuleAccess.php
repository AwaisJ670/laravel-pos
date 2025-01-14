<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin\Modules;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = '/' . $request->path();
        // dd($route);

        $module=Modules::where('route', $route)->pluck('id')->first();

        $assignedModules = Role::where('id', Auth::user()->role_id)->pluck('permissions')->first();


        if (!in_array($module, $assignedModules, true)) {
            // Redirect the user to the 'afterLogin' route
            if (in_array(1, $assignedModules, true)) {
                // Redirect the user to the 'dashboard' route
                return redirect()->route('dashboard');
            }
            else{
                return redirect()->route('afterLogin');
            }
        }

        return $next($request);

    }
}
