<?php

namespace Canvas\Tests\Http\Controllers;

use Canvas\Models\User;
use Canvas\Tests\TestCase;

/**
 * Class HomeControllerTest.
 *
 * @covers \Canvas\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerAssertJsonExactFragmentMacro();
    }

    /** @test */
    public function it_can_load_the_script_variables()
    {
        $user = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);

        $this->actingAs($user, 'canvas')
             ->get(config('canvas.path'))
             ->assertSuccessful()
             ->assertViewIs('canvas::layout')
             ->assertViewHas('config')
             ->assertSee('canvas');
    }
}
