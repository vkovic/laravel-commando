<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommandos\Test\Support\Models\Product;
use Vkovic\LaravelCommandos\Test\TestCase;

class ModelFieldsCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_1_when_model_not_exist()
    {
        $this->artisan('model:fields', [
            'model' => 'non_existing_model_class'
        ])
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function it_can_show_model_fields()
    {
        // Mock db handler
        $this->mock(AbstractDbHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('getColumns')->once();
        });

        $this->artisan('model:fields', [
            'model' => Product::class
        ])
            ->assertExitCode(0);
    }
}