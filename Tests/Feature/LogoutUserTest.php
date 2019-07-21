<?php
/**
 * LogoutUserTest.php
 * Created by @anonymoussc on 07/21/2019 8:28 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/21/19 11:03 AM
 */

namespace App\Components\Scaffold\Tests\Feature;

/**
 * Class LogoutUserTest
 * @package App\Components\Scaffold\Tests\Feature
 */
class LogoutUserTest extends \Tests\PasswordApiTestCase
{
    /**
     * @return void
     */
    public function testLogoutUser(): void
    {
        $this->init();

        /*$header = [
            'Accept'       => 'application/vnd.api+json',
        ];*/

        $header['Accept']       = 'application/vnd.api+json';
        $header['Content-Type'] = 'application/vnd.api+json';

        $resp = $this->json('POST', '/api/login', [
            "username" => "user",
            "password" => "user",
        ], $header);

        //$x = $resp->getContent();

        $content = json_decode($resp->getContent());

        $header['Authorization'] = "Bearer $content->access_token";

        $response = $this->json('POST', '/api/logout', [], $header);

        // $response->dumpHeaders();

        // $response->dump();

        $response->assertStatus(204);
    }
}
