<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

trait InteractsWithDatabase
{
    use DatabaseTransactions;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        // Disable searchable trait to speed up tests.
        \App\Models\Post::disableSearchSyncing();
        \App\Models\Tag::disableSearchSyncing();
        \App\Models\User::disableSearchSyncing();

        $this->runDatabaseMigrations();

        $this->seed(TestDatabaseSeeder::class);
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:reset');
        });
    }
}
