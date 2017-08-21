<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;
use Illuminate\Support\Facades\Auth;

class BackendRoutesTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    protected function backendUriWithResponseCodeProvider()
    {
        return [
            [route('canvas.admin'), 200],
            [route('canvas.admin.post.index'), 200],
            [route('canvas.admin.post.edit', 1), 200],
            [route('canvas.admin.tag.index'), 200],
            [route('canvas.admin.tag.edit', 1), 200],
            [route('canvas.admin.upload'), 200],
            [route('canvas.admin.profile.index'), 200],
            [route('canvas.admin.profile.privacy'), 200],
            [route('canvas.admin.tools'), 200],
            [route('canvas.admin.settings'), 200],
            [route('canvas.admin.help'), 200],
            [route('canvas.admin.user.index'), 200],
            [route('canvas.admin.user.edit', 2), 200],
            [route('canvas.admin.user.privacy', 2), 200],
        ];
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
        $response = $this->actingAs(Auth::user())->call('GET', $uri);
        $this->assertEquals($responseCode, $response->status());
    }
}
