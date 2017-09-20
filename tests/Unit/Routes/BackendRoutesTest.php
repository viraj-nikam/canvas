<?php

namespace Tests\Browser\Routes;

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
     *
     * @param string $uri
     * @param int $responseCode
     *
     * @dataProvider backendUriWithResponseCodeProvider
     **/
    public function it_gets_proper_response_codes_from_backend_uris($uri, $responseCode)
    {
        Auth::guard('canvas')->login($this->user);
        $response = $this->actingAs(Auth::user())->call('GET', $uri, $responseCode);
        $this->assertEquals($responseCode, $response->status());
    }

    /**
     * @return array
     */
    public function backendUriWithResponseCodeProvider()
    {
        return [
            [route('canvas'), 200],
            [route('canvas.admin.post'), 200],
            [route('canvas.admin.post.edit', ['id' => 1]), 200],
            [route('canvas.admin.tag'), 200],
            [route('canvas.admin.tag.edit', ['id' => 1]), 200],
            [route('canvas.admin.upload'), 200],
            [route('canvas.admin.profile.index'), 200],
            [route('canvas.admin.profile.privacy'), 200],
            [route('canvas.admin.tools'), 200],
            [route('canvas.admin.settings'), 200],
            [route('canvas.admin.help'), 200],
            [route('canvas.admin.user.index'), 200],
            [route('canvas.admin.user.edit', ['id' => 2]), 200],
            [route('canvas.admin.user.privacy', ['id' => 2]), 200]
        ];
    }
}