<?php

namespace App\Http\Middleware;

use Closure;
use App\Permission;
use App\Role;
use App\Tag;
use Cache;

class CacheService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Cache::has('permissions'))
            Cache::remember('permissions', 60*10, function() { return Permission::all(); });
        
        if(!Cache::has('roles'))
            Cache::remember('roles', 60*10, function() { return Role::all(); });
        
        if(!Cache::has('tags'))
            Cache::remember('tags', 60*10, function() { return Tag::all(); });

        return $next($request);
    }
}
