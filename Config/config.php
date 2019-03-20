<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 3/20/19 11:03 AM
 */

return [
    'name'         => 'Passerby',
    'refreshToken' => [
        'cookie' => [
            'httpOnly' => true,
            'expire'   => 864000 // 864000 value will make the cookies expire in 10 days
        ],
    ],
    'message'      => [
        'notification' => [
            'login'   => false,
            'refresh' => false,
            'logout'  => false,
        ],
    ],
    'client'       => [
        'id'     => env('PASSWORD_CLIENT_ID'),
        'secret' => env('PASSWORD_CLIENT_SECRET'),
    ],
];
