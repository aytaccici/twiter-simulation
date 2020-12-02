<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('migrate');
        $this->artisan('db:seed');

    }
}
