<?php

return [
    /*
        Pre defined permissions
    */
    'permissions' => [
        'view.admin.dashboard' => 'Allows to visit the admin dashboard',
        'view.admin.users' => 'Allows to list all users',
        'view.admin.modules' => 'Allows to list all modules',
        'view.admin.permissions' => 'Allows to list all permissions and roles',
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