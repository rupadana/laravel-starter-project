<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public $permissionsCrud = [
        "indikator",
        "indikator point",
        "indikator group",
        "user",
        "participant",
    ];

    public $permissions = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions([
            "request certificate",
            "approve certificate",
            "reject certificate"
        ]);
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'sanctum']);
        $trainer = Role::create(['name' => 'trainer', 'guard_name' => 'sanctum']);
        $hrd = Role::create(['name' => 'hrd', 'guard_name' => 'sanctum']);

        $this->assignRole($admin, $this->permissions);
        $this->assignRole($hrd, $this->permissions);
        $this->assignRole($trainer, [
            "request certificate",
            "show indikator point",
            "show indikator group",
            "show indikator",
            "create participant",
            "show participant",
            "update participant",
            "remove participant",
        ]);
    }

    public function assignRole($role, array $permissions)
    {
        foreach ($permissions as $key => $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function createPermissions($custom = [])
    {

        $permissions = $this->permissionsCrud;
        foreach ($permissions as $key => $permission) {
            $this->createPermissionCRUD($permission);
        }


        foreach ($custom as $key => $permission) {
            Permission::create(['name' => "$permission", 'guard_name' => 'sanctum']);
            $this->permissions[] = $permission;
        }
    }

    private function createPermissionCRUD($permission)
    {
        Permission::create(['name' => "create $permission", 'guard_name' => 'sanctum']);
        Permission::create(['name' => "show $permission", 'guard_name' => 'sanctum']);
        Permission::create(['name' => "update $permission", 'guard_name' => 'sanctum']);
        Permission::create(['name' => "remove $permission", 'guard_name' => 'sanctum']);

        $this->permissions[] = "create $permission";
        $this->permissions[] = "show $permission";
        $this->permissions[] = "update $permission";
        $this->permissions[] = "remove $permission";
    }
}
