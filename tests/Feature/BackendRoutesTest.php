<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;
use Illuminate\Support\Facades\Auth;

class AdminRoutesTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /** @test */
    public function it_can_access_the_home_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_posts_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.post.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_edit_posts_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.post.edit', 1));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_tags_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.tag.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_edit_tags_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.tag.edit', 1));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_media_library_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.upload'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_profile_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.profile.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_profile_privacy_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.profile.privacy'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_tools_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.tools'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_settings_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.settings'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_help_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.help'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_users_index_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.user.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_edit_users_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.user.edit', 2));
        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_access_the_edit_users_privacy_page()
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', route('canvas.admin.user.privacy', 2));
        $response->assertStatus(200);
    }
}
