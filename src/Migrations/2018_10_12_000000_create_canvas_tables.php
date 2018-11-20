<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanvasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvas_posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('summary');
            $table->text('body');
            $table->dateTime('published_at')->default('2018-10-12 00:00:00');
            $table->string('featured_image')->nullable();
            $table->string('featured_image_caption');
            $table->string('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('canvas_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
        });

        Schema::create('canvas_posts_tags', function (Blueprint $table) {
            $table->uuid('post_id');
            $table->uuid('tag_id');

            $table->unique(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canvas_posts');
        Schema::dropIfExists('canvas_tags');
        Schema::dropIfExists('canvas_posts_tags');
    }
}
