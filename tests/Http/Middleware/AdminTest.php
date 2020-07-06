<?php

namespace Canvas\Tests\Http\Middleware;

use Canvas\Models\UserMeta;
use Canvas\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_restricts_tag_access_to_non_admins()
    {
        $meta = factory(UserMeta::class)->create();

        $this->actingAs($meta->user)->getJson('canvas/api/tags')->assertForbidden();
        $this->actingAs($meta->user)->getJson('canvas/api/tags/create')->assertForbidden();
        $this->actingAs($meta->user)->postJson('canvas/api/tags/not-a-tag')->assertForbidden();
        $this->actingAs($meta->user)->deleteJson('canvas/api/tags/not-a-tag')->assertForbidden();
    }

    /** @test */
    public function it_restricts_topic_access_to_admins()
    {
        $meta = factory(UserMeta::class)->create();

        $this->actingAs($meta->user)->getJson('canvas/api/topics')->assertForbidden();
        $this->actingAs($meta->user)->getJson('canvas/api/topics/create')->assertForbidden();
        $this->actingAs($meta->user)->postJson('canvas/api/topics/not-a-topic')->assertForbidden();
        $this->actingAs($meta->user)->deleteJson('canvas/api/topics/not-a-topic')->assertForbidden();
    }

    /** @test */
    public function it_restricts_user_access_to_admins()
    {
        $meta = factory(UserMeta::class)->create();

        $this->actingAs($meta->user)->getJson('canvas/api/users')->assertForbidden();
    }
}
