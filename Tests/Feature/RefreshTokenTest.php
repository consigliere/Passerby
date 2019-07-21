<?php

/**
 * RefreshTokenTest.php
 * Created by @anonymoussc on 07/21/2019 8:22 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/21/19 10:05 AM
 */

namespace App\Components\Scaffold\Tests\Feature;

/**
 * Class RefreshTokenTest
 * @package App\Components\Scaffold\Tests\Feature
 */
class RefreshTokenTest extends \Tests\PasswordApiTestCase
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

        $resp = $this->json('POST', '/api/login', [
            "username" => "user",
            "password" => "user",
        ], $header);

        //$x = $resp->getContent();

        $content = json_decode($resp->getContent());

        $response = $this->json('POST', '/api/login/refresh', [
            "refreshToken" => $content->refresh_token,
        ], $header);

        // $response->dumpHeaders();

        // $response->dump();

        $response->assertStatus(200);
    }
}
