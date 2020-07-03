<?php

namespace Canvas\Tests\Helpers;

use Canvas\Helpers\URL;
use Canvas\Tests\TestCase;

class URLTest extends TestCase
{
    /** @test */
    public function it_can_check_for_valid_urls()
    {
        $response = URL::isValid('https://www.example.com');

        $this->assertTrue($response);

        $response = URL::isValid('://www.example.c');

        $this->assertFalse($response);
    }

    /** @test */
    public function it_can_trim_a_url()
    {
        $response = URL::trim('https://www.example.com?string-to-trim');

        $this->assertSame($response, 'www.example.com');
    }
}
