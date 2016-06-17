<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the User model database seed.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            User::truncate();

            DB::table('users')->insert([
                'first_name'    => config('blog.first_name'),
                'last_name'     => config('blog.last_name'),
                'display_name'  => config('blog.display_name'),
                'url'           => 'www.' . seoUrl(config('blog.title')) . '.com',
                'address'       => '1200 Canvas Way',
                'city'          => 'Minneapolis',
                'state'         => 'MN',
                'bio'           => 'A short description of yourself is a great way for people to get to know you!',
                'job'           => 'Web Developer',
                'phone'         => '0001110000',
                'gender'        => 'Male',
                'relationship'  => 'Married',
                'birthday'      => '2016-06-17',
                'email'         => 'admin@' . seoUrl(config('blog.title')) . '.com',
                'password'      => bcrypt('password'),
                'created_at'    => Carbon\Carbon::now(),
                'updated_at'    => Carbon\Carbon::now()
            ]);

        Model::reguard();
    }
}
