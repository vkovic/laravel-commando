<?php

namespace Vkovic\LaravelCommando\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Database\AbstractDbHandler;
use Vkovic\LaravelCommando\Test\Support\Models\Product;
use Vkovic\LaravelCommando\Test\TestCase;

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
            $mock->shouldReceive('getColumns')->once()->andReturn([]);
        });

        $this->artisan('model:fields', [
            'model' => Product::class
        ])
            ->assertExitCode(0);
    }
}