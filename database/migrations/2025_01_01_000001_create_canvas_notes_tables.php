<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanvasNotesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canvas_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('body')->nullable();
            $table->uuid('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('canvas_notes_tags', function (Blueprint $table) {
            $table->uuid('note_id');
            $table->uuid('tag_id');
            $table->unique(['note_id', 'tag_id']);
        });

        Schema::create('canvas_notes_topics', function (Blueprint $table) {
            $table->uuid('note_id');
            $table->uuid('topic_id');
            $table->unique(['note_id', 'topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canvas_notes');
        Schema::dropIfExists('canvas_notes_tags');
        Schema::dropIfExists('canvas_notes_topics');
    }
}

