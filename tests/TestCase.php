<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from user");
    }
    function tearDown(): void
    {
        DB::delete("delete from user where name='test'");
    }
}
