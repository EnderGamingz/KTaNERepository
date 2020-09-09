<?php

namespace App\Policies;

use App\Module;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function view(User $user, Module $module)
    {
        return ($module->public && $module->approved)
            || ($user && $module->maintainer && $module->maintainer->contains('id', $user->id))
            || ($user && $module->publisher_id == $user->id)
            || ($user->hasPermission('view.admin.models'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function update(User $user, Module $module)
    {
        return ($user && $module->maintainer && $module->maintainer->contains('id', $user->id))
            || ($user && $module->publisher_id == $user->id)
            || ($user->hasPermission('edit.admin.models'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Module  $module
     * @return mixed
     */
    public function delete(User $user, Module $module)
    {
        
        return ($user && $module->maintainer && $module->maintainer->contains('id', $user->id))
            || ($user && $module->publisher_id == $user->id)
            || ($user->hasPermission('delete.admin.models'));
    }

    public function approve(User $user, Module $module)
    {
        return ($user->hasPermission('approve.admin.modules'));
    }
}
