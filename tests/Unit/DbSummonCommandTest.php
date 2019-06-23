<?php

namespace Vkovic\LaravelCommandos\Test\Unit;

use Illuminate\Support\Facades\Artisan;
use Vkovic\LaravelCommandos\Test\Support\Fakes\Artisan as FakeArtisan;
use Vkovic\LaravelCommandos\Test\TestCase;

class DbSummonCommandTest extends TestCase
{
    /**
     */
    public function it_can_perform_summon()
    {
        $fakeArtisan = app(FakeArtisan::class);
        $fakeArtisan->skipCommands(['migrate', 'db:seed']);

        Artisan::swap($fakeArtisan);

        $this->artisan('db:summon');
//            ->expectsOutput('Done')
//            ->assertExitCode(0);
    }
}