<?php
/**
 * PasswordApiTestCase.php
 * Created by @anonymoussc on 07/21/2019 7:46 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/21/19 8:10 AM
 */

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

/**
 * Class PasswordApiTestCase
 * @package Tests
 */
abstract class PasswordApiTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function init(): void
    {
        Passport::actingAs(
            factory(\Api\User\Entities\User::class)->create(['uuid' => randomUuid(), 'username' => 'test' . mt_rand()])
        );
    }
}
