<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionUtils
{
    public static function getPermissions()
    {
        return Permission::all();
    }


    public static function getPermissionsByRole($role)
    {
        return $role->permissions;
    }

    public static function getPermissionsByUser($user)
    {
        return $user->permissions;
    }

    public static function buildPermission(Collection $ownedPermission)
    {
        $allPermissions = self::getPermissions();

        $permissions = [];

        foreach ($allPermissions as $permission) {

            $permissions[$permission->name] = $ownedPermission->where("id", $permission->id)->first() ? 1 : 0;
        }

        return $permissions;
    }
}
