<?php

namespace Vkovic\LaravelCommandos\Test\Unit;

use Vkovic\LaravelCommandos\Test\TestCase;

class ModelFieldsCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_show_model_fields()
    {
        $this->artisan('model:fields', [
            'model' => 'product'
        ])
            //->expectsOutput('Done')
            ->assertExitCode(0);
    }
}