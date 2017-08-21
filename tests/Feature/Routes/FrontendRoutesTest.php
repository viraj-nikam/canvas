<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;
use Tests\CreatesUser;
use Tests\InteractsWithDatabase;

class PublicRoutesTest extends TestCase
{
    use InteractsWithDatabase, CreatesUser;

    /**
    * Smoke test each URI and compare the response codes.
    *
    * @test
    *
    * @dataProvider uriWithResponseCodeProvider
    **/
    public function testApplicationUriResponses($uri, $responseCode)
    {
        print sprintf('checking URI : %s - to be %d - %s', $uri, $responseCode, PHP_EOL);
        $response = $this->call('GET', $uri);
        $this->assertEquals($responseCode, $response->status());
    }

    public function uriWithResponseCodeProvider()
    {
        return [
            ['/', 200],
            ['/blog/post/hello-world', 200],
            ['/blog?tag=Getting+Started', 200],
            ['/admin', 200],
            ['/password/forgot', 200],
            ['/non-existing', 404],
        ];
    }
}
