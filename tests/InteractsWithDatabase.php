<?php

namespace Tests;

use Canvas\Models\Tag;
use Canvas\Models\Post;
use Canvas\Models\User;
use Canvas\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;

trait InteractsWithDatabase
{
    use DatabaseMigrations;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        // Disable searchable trait to speed up tests.
        Post::disableSearchSyncing();
        Tag::disableSearchSyncing();
        User::disableSearchSyncing();

        $this->runDatabaseMigrations();

        $this->seed(TestDatabaseSeeder::class);
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
//    public function runDatabaseMigrations()
//    {
//        $this->artisan('migrate');
//
//        $this->beforeApplicationDestroyed(function () {
//            $this->artisan('migrate:reset');
//        });
//    }
}
