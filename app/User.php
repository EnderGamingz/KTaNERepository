<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use DB;
use Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return QueryBuilder for user permissions relationship
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    /**
     * @return QueryBuilder for user roles relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * @return QueryBuilder for user-roles and unioned player-permissions relationship
     */
    public function allPermissions()
    {
        $user_permissions = DB::table('user_permission')
            ->join("permissions", "permissions.id", "=", "user_permission.user_id")
            ->where("user_permission.user_id", $this->id)
            ->select('permissions.name');

        $role_permissions = DB::table('users')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('role_permission', 'role_permission.role_id', '=', 'user_role.role_id')
            ->join('permissions', 'permissions.id', '=', 'role_permission.permission_id')
            ->where('users.id', $this->id)
            ->select('permissions.name');
        
        return $role_permissions->union($user_permissions);
    }

    /**
     * Checks where the user has the given permission
     * 
     * @param permission The name of the permission to check for
     * @return boolean True if user has the specified permission, otherwise false
     */
    public function hasPermission($permission)
    {
        // Check if the permission variable has a value
        if(!$permission) {
            return true;
        }

        // Get the users tag from cache
        $tag = Cache::tags(["users"]);
        $permissions = null;

        // Check if the cache contains a set of permissions for the current user
        if($tag->has("permissions-" . $this->id)) {
            // Retrive the set of permissions
            $permissions = $tag->get("permissions-" . $this->id);
        } else {
            // Get all permissions from database
            $permissions = $this->allPermissions()->get();
            // Cache the fetched permissions from database
            $tag->remember("permissions-" . $this->id, 60*5, function() use ($permissions) {
                return $permissions;
            });
        }

        // Check if the user has the permission 
        return $permissions->contains("name", $permission);
    }


}
