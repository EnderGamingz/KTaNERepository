<?php

return [
    /*
        Pre defined permissions
    */
    'permissions' => [
        'view.admin.dashboard' => 'Allows to visit the admin dashboard',
        'view.admin.users' => 'Allows to list all users',
        'show.admin.users' => 'Allows to show users in detail',
        'permissions.admin.users' => 'Allows to assign roles and permissions to a user',
        'view.admin.modules' => 'Allows to list all modules',
        'approve.admin.modules' => 'Allows to approve modules',
        'create.admin.modules' => 'Allows to create new modules',
        'view.admin.permissions' => 'Allows to list all permissions and roles',
        'show.admin.roles' => 'Allows to show roles in detail',
        'create.admin.roles' => 'Allows to create new roles',
        'edit.admin.roles' => 'Allows to edit existing roles',
        'sync.admin.permissions' => 'Allows to sync permissions',
    ],


    /*
        Pre defined roles
    */
    'roles' => [
        'admin' => [
            'description' => 'Super User',
            'permissions' => '*',
        ]
    ]

];