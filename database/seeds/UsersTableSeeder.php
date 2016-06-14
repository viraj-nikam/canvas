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
                'address'       => config('blog.address'),
                'city'          => config('blog.city'),
                'state'         => config('blog.state'),
                'bio'           => config('blog.bio'),
                'job'           => config('blog.job'),
                'phone'         => config('blog.phone'),
                'gender'        => config('blog.gender'),
                'relationship'  => config('blog.relationship'),
                'birthday'      => config('blog.birthday'),
                'email'         => 'admin@' . seoUrl(config('blog.title')) . '.com',
                'header_image'  => '4.png',
                'password'      => bcrypt('password'),
                'created_at'    => Carbon\Carbon::now(),
                'updated_at'    => Carbon\Carbon::now()
            ]);

        Model::reguard();
    }
}
