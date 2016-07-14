<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TeamTNT\TNTSearch\TNTSearch;

class IndexPosts extends Command
{
    protected $tnt;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index the posts and tags table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tnt = new TNTSearch;
        $this->tnt->loadConfig(config('services.tntsearch'));

        $this->createPostsIndex();
        $this->createTagsIndex();
    }

    public function createPostsIndex()
    { 
        $this->info("Creating posts.index");
        $indexer = $this->tnt->createIndex('posts.index');
        $indexer->query('SELECT id, title, subtitle, content_raw, meta_description FROM posts;');
        $indexer->run();
    }

    public function createTagsIndex()
    {
        $this->info("Creating tags.index");
        $indexer = $this->tnt->createIndex('tags.index');
        $indexer->query('SELECT id, tag, title, subtitle, meta_description FROM tags;');
        $indexer->run();
    }
}
