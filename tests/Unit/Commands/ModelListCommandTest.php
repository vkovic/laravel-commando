<?php

namespace Vkovic\LaravelCommandos\Test\Unit\Commands;

use Mockery\MockInterface;
use Vkovic\LaravelCommandos\Handlers\Helper;
use Vkovic\LaravelCommandos\Test\Support\Models\Product;
use Vkovic\LaravelCommandos\Test\TestCase;

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