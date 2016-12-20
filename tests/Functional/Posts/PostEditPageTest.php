<?php

class PostEditPageTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_edit_posts()
    {
        $this->callRouteAsUser('admin.post.edit', 1)
            ->submitForm('Update', ['title' => 'Foo'])
            ->see('Success! Post has been updated')
            ->see('Foo')
            ->seePostInDatabase();
    }

    /** @test */
    public function it_can_preview_a_post()
    {
        $this->callRouteAsUser('admin.post.edit', 1)
            ->click('permalink')
            ->seePageIs('blog/hello-world')
            ->assertSessionMissing('errors');
    }

    /** @test */
    public function it_can_delete_a_post_from_the_database()
    {
        $this->callRouteAsUser('admin.post.edit', 1)
            ->press('Delete Post')
            ->see($this->getDeleteMessage())
            ->dontSeePostInDatabase(1)
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