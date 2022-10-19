<?php

namespace App\Http\Middleware;

use App\Models\GrantPermission;
use App\Models\Role;
use App\Models\Route;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HandleAuthorAdmin
{
    public function checkRoute($arrPermission = []) {
        $currentURL = url()->current();
        $rootUrl = url('/');
        $path = str_replace($rootUrl, '', $currentURL);
        if (!empty(request()->segment(3))) {
            $path = str_replace("/".request()->segment(3), '', $path);
        }
        $checkRoute = Route::where('route', $path)->get();
        if (count($checkRoute)) {
            if (empty($arrPermission[$checkRoute[0]->command_id][$checkRoute[0]->permission_id])) {
                return false;
            }
        }
        return true;
    }

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $roleIds = [];
        foreach ($user->userHasRoles as $role) {
            array_push($roleIds, $role->role_id);
        }

        // handle command of user
        $roles = Role::whereIn('id', $roleIds)->get();

        $arrCommands = [];
        foreach ($roles as $role) {
            foreach ($role->roleHasPermission as $command) {
                // dd($role->roleHasPermission);
                if (empty($arrCommands[$command->command->id])) {
                    $arrCommands[$command->command->id] = $command->command->name;
                }
            }
        }

        // handle commands and permissions of user
        $arrPermission = [];
        foreach ($roles as $role) {
            foreach ($role->roleHasPermission as $command) {
                if (empty($arrPermission[$command->command->id])) {
                    $arrPermission[$command->command->id] = [];
                }
                if (empty($arrPermission[$command->command->id][$command->permission->id])) {
                    $arrPermission[$command->command->id][$command->permission->id] = $command->permission->name;
                }
            }
        }

        // handle grant commands and permissions for user
        $grantPermissions = GrantPermission::where('user_id', $user->id)
            ->where('expired_date', '>', now())->get();
        if (count($grantPermissions)) {
            foreach ($grantPermissions as $grant) {
                if (empty($arrCommands[$grant->command_id])) {
                    $arrCommands[$grant->command_id] = $grant->command->name;
                }
                if (empty($arrPermission[$grant->command_id])) {
                    $arrPermission[$grant->command->id] = [];
                }
                if (empty($arrPermission[$grant->command->id][$grant->permission->id])) {
                    $arrPermission[$grant->command->id][$grant->permission->id] = $grant->permission->name;
                }
            }
        }

        // dd($arrPermission);

        if(!$this->checkRoute($arrPermission)) {
            return redirect(url()->previous());
        }

        Config::set('permissions', $arrPermission);
        Config::set('commands', $arrCommands);
        Config::set('user', $user);

        return $next($request);
    }
}
