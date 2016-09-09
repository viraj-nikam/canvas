<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Initial User Seed Data
|--------------------------------------------------------------------------
|
| Here you may set the user information details for the application
| administrator. Don't worry, you can always edit these
| details within the application.
|
*/
class UsersTableSeeder extends Seeder
{
    /**
     * Run the User model database seed.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('users')->insert([
            /*
            |--------------------------------------------------------------------------
            | Summary
            |--------------------------------------------------------------------------
            */
            'bio'           => 'A short description of yourself is a great way for people to get to know you!',

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */
            'first_name'    => 'John',
            'last_name'     => 'Doe',
            'display_name'  => 'Administrator',
            'job'           => 'Web Developer',
            'gender'        => 'Male',
            'birthday'      => '1980-02-29',
            'relationship'  => 'Single',

            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */
            'phone'         => '(123) 123-1234',
            'email'         => 'admin@canvas.com',
            'twitter'       => 'username',      // Example: https://twitter.com/username
            'facebook'      => 'username',      // Example: https://facebook.com/username
            'github'        => 'username',      // Example: https://github.com/username
            'linkedin'      => 'username',      // Example: https://linkedin.com/in/username
            'address'       => '5479 Main Street',
            'city'          => 'New York',
            'country'       => 'USA',

            /*
            |--------------------------------------------------------------------------
            | Misc Information
            |--------------------------------------------------------------------------
            */
            'url'           => 'www.john-doe.io',
            'password'      => bcrypt('password'),

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */
            'created_at'    => Carbon\Carbon::now(),
            'updated_at'    => Carbon\Carbon::now(),
        ]);
    }
}
