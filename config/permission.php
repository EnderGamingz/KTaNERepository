<?php

return [
    /*
        Pre defined permissions
    */
    'permissions' => [
        'view.admin.dashboard' => 'Allows to visit the admin dashboard',
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