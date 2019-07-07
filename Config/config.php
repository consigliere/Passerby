<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/8/19 5:49 AM
 */

return [
    'name'         => 'Passerby',
    'refreshToken' => [
        'cookie' => [
            'httpOnly' => true,
            'expire'   => 864000 // 864000 value will make the cookies expire in 10 days
        ],
    ],
    'log'          => [ // log info into database, default into signal_log table
        'info' => [
            'login'   => [
                'active'  => false,
                'message' => 'User has successfully login.',
            ],
            'logout'  => [
                'active'  => false,
                'message' => 'User has successfully logout.',
            ],
        ],
    ],
    'client'       => [
        'id'     => env('PASSWORD_CLIENT_ID'),
        'secret' => env('PASSWORD_CLIENT_SECRET'),
    ],
];
