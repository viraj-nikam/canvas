<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            User::truncate();

            DB::table('users')->insert([
                'name' => 'Canvas Administrator',
                'email' => 'foo@bar.com',
                'password' => bcrypt('password'),
            ]);

        Model::reguard();
    }
}
