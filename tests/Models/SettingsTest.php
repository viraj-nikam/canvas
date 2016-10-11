<?php

use EGALL\EloquentPHPUnit\EloquentTestCase;

class SettingsTest extends EloquentTestCase
{
    /**
     * The user model's full namespace.
     *
     * @var string
     */
    protected $model = 'App\Models\Settings';

    /**
     * Disable database seeding.
     *
     * @var bool
     */
    protected $seedDatabase = false;

    /** @test */
    public function it_has_the_correct_model_properties()
    {
        $this->hasFillable(['setting_name', 'setting_value']);
    }
}
