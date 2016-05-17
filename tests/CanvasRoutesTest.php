<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CanvasRoutesTest extends TestCase
{
    /**
     * Test the response code for the home page.
     *
     * @return void
     */
    public function testHomePageResponseCode()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the login page.
     *
     * @return void
     */
    public function testLoginPageResponseCode()
    {
        $response = $this->call('GET', '/auth/login');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the 404 error page.
     *
     * @return void
     */
    public function test404ErrorPageResponseCode()
    {
        $response = $this->call('GET', '/404ErrorPage');
        $this->assertEquals(302, $response->status());
    }
}
