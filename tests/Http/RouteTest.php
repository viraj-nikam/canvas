<?php

namespace Canvas\Tests\Http;

use Canvas\Tests\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    public function it_has_a_base_named_route()
    {
        $this->assertEquals(
            url(config('canvas.path')),
            route('canvas')
        );
    }
}
