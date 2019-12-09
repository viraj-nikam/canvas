<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCanvasViewsRenameIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('canvas_views', function (Blueprint $table) {
            $table->renameIndex('post_id', 'canvas_views_post_id_index');
            $table->renameIndex('created_at', 'canvas_views_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('canvas_views', function (Blueprint $table) {
            $table->renameIndex('canvas_views_post_id_index', 'post_id');
            $table->renameIndex('canvas_views_created_at_index', 'created_at');
        });
    }
}
