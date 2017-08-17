<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;

class PublicRoutesTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_access_the_blog_index_page()
    {
        $response = $this->call('GET', '/');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_a_blog_post_page()
    {
        $response = $this->call('GET', '/blog/post/hello-world');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_a_blog_tag_page()
    {
        $response = $this->call('GET', '/blog?tag=Getting+Started');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_login_page()
    {
        $response = $this->call('GET', '/admin');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_forgot_password_page()
    {
        $response = $this->call('GET', '/password/forgot');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_will_receive_a_404_error_if_a_page_is_not_found()
    {
        $response = $this->call('GET', '/404ErrorPage');
        $response->assertStatus(404);
    }
}
