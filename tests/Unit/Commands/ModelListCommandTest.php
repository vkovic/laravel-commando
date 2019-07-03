<?php

namespace Vkovic\LaravelCommando\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Helper;
use Vkovic\LaravelCommando\Test\Support\Models\Product;
use Vkovic\LaravelCommando\Test\TestCase;

class ModelListCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_list_models()
    {
        $this->mock(Helper::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAllModelClasses')->once()->andReturn([]);
        });

        $this->artisan('model:list')->assertExitCode(0);
    }
}