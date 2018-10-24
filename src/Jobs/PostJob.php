<?php

namespace Canvas\Jobs;

use Exception;
use Canvas\Entities\Post;
use Illuminate\Bus\Queueable;
use Canvas\Interfaces\PostInterface;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * @var array
     */
    public $request = [];

    /**
     * @var Post
     */
    public $post;

    /**
     * Create a new job instance.
     *
     * @param array $request
     * @param Post|null $post
     */
    public function __construct(array $request = [], Post $post = null)
    {
        $this->request = $request;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        if ($this->post) {
            $this->post->update($this->request);
            if (array_key_exists('tags', $this->request)) {
                $this->post->tags()->sync($this->request['tags']);
            }
        } else {
            $post = app(PostInterface::class)->create([
                'user_id'      => auth()->user()->id,
                'title'        => $this->request['title'],
                'summary'      => $this->request['summary'],
                'body'         => $this->request['body'],
                'slug'         => str_slug($this->request['title']),
                'published_at' => $this->request['published_at'],
            ]);
            $post->save();
            if (array_key_exists('tags', $this->request)) {
                $post->tags()->sync($this->request['tags']);
            }
        }
    }
}
