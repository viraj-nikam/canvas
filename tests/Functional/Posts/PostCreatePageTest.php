<?php

class PostCreatePageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_press_cancel_to_return_to_the_post_index_page()
    {
        $this->actingAs($this->user)
            ->visit('/admin/post/create')
            ->click('Cancel');
        $this->assertSessionMissing('errors');
        $this->seePageIs('/admin/post');
    }

    /** @test */
    public function it_validates_the_post_create_form()
    {
        $this->callRouteAsUser('admin.post.store', null, ['title' => 'example'])
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_create_a_post_and_save_it_to_the_database()
    {
        $data = [
            'id'            => 2,
            'user_id'       => 1,
            'title'         => 'example',
            'slug'          => 'foo',
            'subtitle'      => 'bar',
            'content'       => 'FooBar',
            'published_at'  =>  Carbon\Carbon::now(),
            'layout'        => config('blog.post_layout'),
        ];

        $this->callRouteAsUser('admin.post.store', null, $data)
            ->seePostInDatabase(['title' => 'example', 'content_raw' => 'FooBar', 'content_html' => '<p>FooBar</p>'])
            ->seeInSession('_new-post', trans('messages.create_success', ['entity' => 'post']))
            ->assertRedirectedTo('admin/post/2/edit')
            ->assertSessionMissing('errors');
    }

    /**
     * Get or post to a route as a user.
     *
     * @param  string           $route       The route's name.
     * @param  array|int|null   $routeData   The route's parameters.
     * @param  array|null       $requestData The data that should be posted to the server.
     * @return void
     */
    protected function callRouteAsUser($route, $routeData = null, $requestData = null)
    {
        $request = $this->actingAs($this->user);

        if (is_null($requestData)) {
            return $request->visit(route($route, $routeData));
        }

        return $request->post(route($route, $routeData), $requestData);
    }

    /**
     * Assert that a post model is not in the database by id.
     *
     * @param  int $id
     * @return $this
     */
    protected function dontSeePostInDatabase($id)
    {
        return $this->seePostInDatabase(['id' => $id], true);
    }

    /**
     * Get the post deletion success message.
     *
     * @return string
     */
    protected function getDeleteMessage()
    {
        return 'Success! Post has been deleted.';
    }

    /**
     * Assert that data can be found in the posts table.
     *
     * @param  array   $data
     * @param  bool $negate Should the assertion be negated (dontSeeInDatabase)
     * @return $this
     */
    protected function seePostInDatabase($data = ['title' => 'Foo'], $negate = false)
    {
        $method = $negate ? 'dontSeeInDatabase' : 'seeInDatabase';

        return $this->$method('posts', $data);
    }
}
