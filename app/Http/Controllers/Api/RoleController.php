<?php

namespace App\Http\Controllers\Api;

use App\Events\Role\DestroyRoleEvent;
use App\Events\Role\StoreRoleEvent;
use App\Events\Role\UpdateRoleEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\DetailRoleResource;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $role = Role::create($request->except('permissions'));

            $permissions = $request->permissions;

            foreach ($permissions as $key => $permission) {
                $role->givePermissionTo($permission);
            }

            DB::commit();

            event(new StoreRoleEvent($role));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['message' => 'Role created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new DetailRoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->syncPermissions($request->get('permissions'));

        event(new UpdateRoleEvent($role));

        return new DetailRoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        event(new DestroyRoleEvent($role));

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
