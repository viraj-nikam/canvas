<?php

use App\Tag;
use App\Post;

class PostTest extends PHPUnit_Framework_TestCase
{

    protected $post;

    public function setUp()
    {
        $this->post = new Post('My New Post');
    }

    /** @test */
    function a_post_has_a_name()
    {

        // Not working
        $this->assertEquals('My New Post', $this->post->name());
    }

}
