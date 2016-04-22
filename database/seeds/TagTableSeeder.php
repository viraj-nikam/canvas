<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TagTableSeeder extends Seeder
{
  /**
   * Seed the tags table
   */
  public function run()
  {
    Model::unguard();

        Tag::truncate();

        factory(Tag::class, 5)->create();

    Model::reguard();
  }
}