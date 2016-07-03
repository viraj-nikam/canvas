<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class PublicRoutesTest
 *
 * Test the response code for each publicly accessible route.
 */
class PublicRoutesTest extends TestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the response code for the Blog page.
     *
     * @return void
     */
    public function testBlogPageResponseCode()
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the Login page.
     *
     * @return void
     */
    public function testLoginPageResponseCode()
    {
        $response = $this->call('GET', '/auth/login');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the 404 Error Page.
     *
     * @return void
     */
    public function test404ErrorPageResponseCode()
    {
        $response = $this->call('GET', '/404ErrorPage');
        $this->assertEquals(404, $response->status());
    }
}
