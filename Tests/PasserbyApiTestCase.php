<?php
/**
 * PasserbyApiTestCase.php
 * Created by @anonymoussc on 07/21/2019 7:46 AM.
 */

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/21/19 7:48 AM
 */

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

/**
 * Class PasserbyApiTestCase
 * @package Tests
 */
abstract class PasserbyApiTestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function init(): void
    {
        Passport::actingAs(
            factory(\Api\User\Entities\User::class)->create(['role_id' => 2, 'uuid' => randomUuid(), 'username' => 'test' . mt_rand()])
        );
    }
}
