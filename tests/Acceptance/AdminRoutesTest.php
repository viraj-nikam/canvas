<?php

/**
 * Class AdminRoutesTest
 *
 * Test the response code for each administrative route after login.
 */
class AdminRoutesTest extends TestCase
{
    /**
     * Authenticate a user and log them in for further tests.
     */
    private function userLogin()
    {
        $this->visit('/auth/login')
            ->type('admin@canvas.com', 'email')
            ->type('password', 'password')
            ->press('submit')
            ->seePageIs('/admin/post');
    }

    /**
     * Test the response code for the Posts page.
     *
     * @return void
     */
    public function testPostsPageResponseCode()
    {
        $this->userLogin();
        $response = $this->call('GET', '/admin/post');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the Tags page.
     *
     * @return void
     */
    public function testTagsPageResponseCode()
    {
        $this->userLogin();
        $response = $this->call('GET', '/admin/tag');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the Uploads page.
     *
     * @return void
     */
    public function testUploadsPageResponseCode()
    {
        $this->userLogin();
        $response = $this->call('GET', '/admin/upload');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the Profile page.
     *
     * @return void
     */
    public function testProfilePageResponseCode()
    {
        $this->userLogin();
        $response = $this->call('GET', '/admin/profile');
        $this->assertEquals(200, $response->status());
    }
}
