<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\QueryBuilder\QueryBuilder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = "sanctum";


    /**
     * Only Logs this attribute
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'email'];

    /**
     * Logs only changed attributes.
     */
    protected static $logOnlyDirty = true;


    /**
     * Don't store if no changes
     */
    protected static $submitEmptyLogs = false;

    /**
     * Logs the user that caused the activity.
     */
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = "user.activity.{$eventName}";
    }



    public static function doPagination($perPage = 10): LengthAwarePaginator
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'email'])
            ->allowedSorts(['name', 'email']);

        return $users->paginate($perPage);
    }
}
