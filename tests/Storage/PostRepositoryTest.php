<?php

namespace Canvas\Tests\Storage;

use Canvas\Post;
use Canvas\Tests\TestCase;
use Illuminate\Support\Str;

class PostRepositoryTest extends TestCase
{
    /** @test */
    public function find_by_uuid()
    {
        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $post = factory(Post::class)->create();

        $result = Post::find($post->id)->jsonSerialize();

        $this->assertSame($post->id, $result['id']);
        $this->assertSame($post->slug, $result['slug']);
        $this->assertSame($post->title, $result['title']);
        $this->assertSame($post->user_id, $result['user_id']);
    }

    /** @test */
    public function calculate_human_friendly_read_time()
    {
        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $post = factory(Post::class)->create();

        $word_count = str_word_count($post->body);
        $minutes = ceil($word_count / 250);

        $this->assertSame(
            $post->readTime,
            sprintf('%d %s %s', $minutes, Str::plural(__('canvas::stats.details.reading.time'), $minutes), __('canvas::stats.details.reading.read'))
        );
    }
}
