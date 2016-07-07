<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructurePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('subtitle')->after('title')->default('');
            $table->renameColumn('content', 'content_raw');
            $table->text('content_html')->after('content')->default('');
            $table->string('page_image')->after('content_html')->default('');
            $table->string('meta_description')->after('page_image')->default('');
            $table->boolean('is_draft')->after('meta_description')->default(false);
            $table->string('layout')->after('is_draft')->default('frontend.blog.post');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('layout');
            $table->dropColumn('is_draft');
            $table->dropColumn('meta_description');
            $table->dropColumn('page_image');
            $table->dropColumn('content_html');
            $table->renameColumn('content_raw', 'content');
            $table->dropColumn('subtitle');
        });
    }
}
