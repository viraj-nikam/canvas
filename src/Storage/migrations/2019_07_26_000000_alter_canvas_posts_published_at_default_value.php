<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCanvasPostsPublishedAtDefaultValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('canvas_posts', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('canvas_posts', function (Blueprint $table) {
            $table->dateTime('published_at')->default('2018-10-12 00:00:00')->change();
        });
    }
}
