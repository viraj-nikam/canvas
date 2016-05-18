<?php

class ParsedownerTest extends PHPUnit_Framework_TestCase
{
    protected $parsedowner;

    public function setup()
    {
        $this->parsedowner = new \App\Services\Parsedowner();
    }

    /**
     * @dataProvider conversionsProvider
     */
    public function testConversions($value, $expected)
    {
        $this->assertEquals($expected, $this->parsedowner->toHTML($value));
    }

    public function conversionsProvider()
    {
        return [
            ["text", "<p>text</p>"],
            ["# title", "<h1>title</h1>"],
            ["## title", "<h2>title</h2>"],
            ["### title", "<h3>title</h3>"],
            ["#### title", "<h4>title</h4>"],
            ["`hello_world`", "<p><code>hello_world</code></p>"],
            ["*italics text*", "<p><em>italics text</em></p>"],
            ["**bold text**", "<p><strong>bold text</strong></p>"],
            ["---", "<hr />"],
        ];
    }
}