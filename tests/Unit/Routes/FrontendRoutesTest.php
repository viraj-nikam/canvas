<?php

namespace Tests\Browser\Routes;

use Tests\TestCase;
use Tests\InteractsWithDatabase;

class FrontendRoutesTest extends TestCase
{
    use InteractsWithDatabase;

    /**
     * Smoke test each URI and compare the response codes.
     *
     * @test
     *
     * @param string $uri
     * @param int $responseCode
     *
     * @dataProvider frontendUriWithResponseCodeProvider
     */
    public function it_gets_proper_response_codes_from_frontend_uris($uri, $responseCode)
    {
        $response = $this->call('GET', $uri);
        $this->assertEquals($responseCode, $response->status());
    }

    /**
     * @return array
     */
    public static function frontendUriWithResponseCodeProvider()
    {
        return [
            ['/', 200],
            ['/blog/post/hello-world', 200],
            ['/blog?tag=Getting+Started', 200],
            ['/admin', 200],
            ['/password/forgot', 200],
            ['/non-existing', 404]
        ];
    }
}
