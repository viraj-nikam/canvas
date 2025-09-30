<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canvas_notes_favorites', function (Blueprint $table) {
            $table->string('note_id');
            $table->string('user_id');
            $table->timestamps();

            $table->primary(['note_id', 'user_id']);
            $table->index('user_id');
            $table->index('note_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canvas_notes_favorites');
    }
};

