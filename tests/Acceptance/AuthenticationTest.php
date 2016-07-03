<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class AuthenticationTest
 *
 * Test the login and logout functionality of the application.
 */
class AuthenticationTest extends TestCase
{

    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Test the ability for a user to log into the application.
     *
     * @return void
     */
    public function testApplicationLogin()
    {
        $this->seed(UsersTableSeeder::class);
        $this->visit('/auth/login')
             ->type('admin@canvas.com', 'email')
             ->type('password', 'password')
             ->press('submit')
             ->seePageIs('/admin/post');
    }

    /**
     * Test the ability for a user to log out of the application.
     *
     * @return void
     */
    public function testApplicationLogout()
    {
        $this->seed(UsersTableSeeder::class);
        $this->visit('/auth/login')
             ->type('admin@canvas.com', 'email')
             ->type('password', 'password')
             ->press('submit')
             ->seePageIs('/admin/post')
             ->click('logout')
             ->seePageis('/auth/login');
    }
}
