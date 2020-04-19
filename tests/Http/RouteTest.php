<?php

namespace Canvas\Tests\Http;

use Canvas\Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * The named route should match the configured one.
     *
     * @return void
     */
    public function test_named_route()
    {
        $this->assertEquals(
            url(config('canvas.path')),
            route('canvas')
        );
    }
}
