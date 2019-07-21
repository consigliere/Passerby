<?php
/**
 * AuthenticateUserTest.php
 * Created by @anonymoussc on 07/21/2019 8:00 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/21/19 8:01 AM
 */

namespace App\Components\Scaffold\Tests\Feature;

/**
 * Class AuthenticateUserTest
 * @package App\Components\Scaffold\Tests\Feature
 */
class AuthenticateUserTest extends \Tests\PasserbyApiTestCase
{
    /**
     * @return void
     */
    public function testAuthenticateUser(): void
    {
        $this->init();

        $header = [
            'Accept'       => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];

        $response = $this->json('POST', '/api/login', [
            "username" => "user",
            "password" => "user",
        ], $header);

        // $response->dumpHeaders();

        // $response->dump();

        $response->assertStatus(200);
    }
}
