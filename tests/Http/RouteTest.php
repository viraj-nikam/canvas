<?php

namespace Canvas\Tests\Http;

use Canvas\Tests\TestCase;

class RouteTest extends TestCase
{
    public function testNamedRoute(): void
    {
        $this->assertEquals(
            url(config('canvas.path')),
            route('canvas')
        );
    }
}
