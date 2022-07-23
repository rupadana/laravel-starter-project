<?php

namespace App\Http\Controllers\Api;

use App\Events\DestroyUserEvent;
use App\Events\StoreUserEvent;
use App\Events\UpdateUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $users = User::doPagination($perPage);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        event(new StoreUserEvent($user, $token));

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $email = $request->get("email");
        $password = bcrypt($request->get("password"));
        $name = $request->get("name");

        $role = $request->get("role");

        $user->syncRoles([$role]);

        $user->update([
            "email" => $email,
            "password" => $password,
            "name" => $name,
        ]);

        event(new UpdateUserEvent($user, $request));

        return response()->json([
            'message' => 'Data berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        event(new DestroyUserEvent($user));
        $user->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
