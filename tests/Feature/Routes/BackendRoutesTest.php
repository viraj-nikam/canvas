<?php

namespace Tests\Feature\Routes;

use Auth;
use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;

class BackendRoutesTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /**
    * @return void
    **/
    public function setUp()
    {
        parent::setUp();

        $this->createApplication();
    }

    /**
    * Smoke test each URI and compare the response codes.
    *
    * @test
    *
    * @dataProvider backendUriWithResponseCodeProvider
    **/
    public function it_gets_proper_response_codes_from_backend_uris($uri, $responseCode)
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', $uri, $responseCode);
        $this->assertEquals($responseCode, $response->status());
    }

    public function backendUriWithResponseCodeProvider()
    {
        return [
            ['/admin', 200],
            ['/admin/post', 200],
            [route('canvas.admin.post.edit', ['id' => 1]), 200],
            ['/admin/tag', 200],
            ['/admin/tag/edit/1', 200],
            ['/admin/upload', 200],
            ['/admin/profile', 200],
            ['/admin/profile/privacy', 200],
            ['/admin/tools', 200],
            ['/admin/settings', 200],
            ['/admin/help', 200],
            ['/admin/user', 200],
            ['/admin/user/edit/2', 200],
            ['/admin/user/privacy/2', 200]
        ];
    }
}
