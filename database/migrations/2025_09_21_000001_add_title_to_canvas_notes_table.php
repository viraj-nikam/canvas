<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToCanvasNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('canvas_notes', function (Blueprint $table) {
            if (!Schema::hasColumn('canvas_notes', 'title')) {
                $table->string('title')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('canvas_notes', function (Blueprint $table) {
            if (Schema::hasColumn('canvas_notes', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
}

