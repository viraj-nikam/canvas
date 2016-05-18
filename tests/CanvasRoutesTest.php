<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CanvasRoutesTest extends TestCase
{
    /**
     * Test the response code for the Landing page.
     *
     * @return void
     */
    public function testLandingPageResponseCode()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the Blog index.
     *
     * @return void
     */
    public function testBlogIndexPageResponseCode()
    {
        $response = $this->call('GET', '/blog');
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
     * Test the response code for a 404 Error.
     *
     * @return void
     */
    public function test404ErrorPageResponseCode()
    {
        $response = $this->call('GET', '/404ErrorPage');
        $this->assertEquals(302, $response->status());
    }
}
