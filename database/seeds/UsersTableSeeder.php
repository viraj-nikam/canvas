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
                'display_name'  => 'Admin',
                'url'           => 'www.' . seoUrl(config('blog.title')) . '.com',
                'email'         => 'admin@' . seoUrl(config('blog.title')) . '.com',
                'password'      => bcrypt('password'),
                'created_at'    => Carbon\Carbon::now()
            ]);

        Model::reguard();
    }
}
