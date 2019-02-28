<?php

namespace Canvas\Tests\Unit;

use Canvas\Topic;
use Canvas\Tests\TestCase;
use Faker\Factory as Faker;

class TopicTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_create_a_tag()
    {
        $topic = $this->createDefaultTopic();

        $this->assertNotEmpty($topic->name);
        $this->assertNotEmpty($topic->slug);
    }

    /** @test */
    public function it_is_retrievable_by_id()
    {
        $topic = $this->createDefaultTopic();
        $topic_by_id = app(Topic::class)->find($topic->id);

        $this->assertEquals($topic->id, $topic_by_id->id);
    }

    /**
     * @return Topic
     */
    private function createDefaultTopic(): Topic
    {
        return Topic::create([
            'id'   => Faker::create()->uuid,
            'slug' => Faker::create()->uuid,
            'name' => Faker::create()->word,
        ]);
    }
}
