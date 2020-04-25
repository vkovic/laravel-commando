<?php

namespace Vkovic\LaravelCommando\Test\Unit\Handlers;

use Mockery\MockInterface;
use Vkovic\LaravelCommando\Handlers\Helper;
use Vkovic\LaravelCommando\Test\Support\Models\Category;
use Vkovic\LaravelCommando\Test\Support\Models\Product;
use Vkovic\LaravelCommando\Test\TestCase;
use function Vkovic\LaravelCommando\package_path;

class HelperTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_exception_on_incorrect_psr_4()
    {
        $this->mock(Helper::class, function (MockInterface $mock) {
            $mock->makePartial()
                ->shouldReceive('getAppPath')->andReturn(package_path('tests'))
                ->shouldReceive('getAppNamespace')->andReturn('Vkovic\\LaravelCommando\\Test\\');
        });

        $helper = app()->make(Helper::class);

        $this->expectExceptionMessage('PSR-4 compatible');
        $helper->getAllModelClasses();
    }

    /**
     * @test
     */
    public function it_can_get_all_model_classes()
    {
        $this->mock(Helper::class, function (MockInterface $mock) {
            $mock->makePartial()
                ->shouldReceive('getAppPath')->andReturn(package_path('tests/Support/Models'))
                ->shouldReceive('getAppNamespace')->andReturn('Vkovic\\LaravelCommando\\Test\\Support\\Models\\');
        });

        $helper = app()->make(Helper::class);

        $models = $helper->getAllModelClasses();

        $this->assertContains(Product::class, $models);
        $this->assertContains(Category::class, $models);
        $this->assertCount(2, $models);
    }
}