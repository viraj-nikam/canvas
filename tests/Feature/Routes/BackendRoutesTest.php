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
    * Smoke test each URI and compare the response codes.
    *
    * @test
    * @dataProvider backendUriWithResponseCodeProvider
    **/
    public function it_gets_proper_response_codes_from_backend_uris($uri, $id = null, $responseCode)
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', $uri, $id, $responseCode);
        $this->assertEquals($responseCode, $response->status());
    }

    /**
    * @return array
    **/
    public static function backendUriWithResponseCodeProvider()
    {
        return [
            ['/admin', null, 200],
            ['/admin/post', null, 200],
            ['/admin/post/edit', 1, 200],
            ['/admin/tag', null, 200],
            ['/admin/tag/edit', 1, 200],
            ['/admin/upload', null, 200],
            ['/admin/profile', null, 200],
            ['/admin/profile/privacy', null, 200],
            ['/admin/tools', null, 200],
            ['/admin/settings', null, 200],
            ['/admin/help', null, 200],
            ['/admin/user', null, 200],
            ['/admin/user/edit', 2, 200],
            ['/admin/user/privacy', 2, 200]
        ];
    }
}
