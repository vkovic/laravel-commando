<?php

namespace Vkovic\LaravelCommandos\Test\Unit;

use Vkovic\LaravelCommandos\Test\TestCase;

class DbCreateCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_database()
    {
        $this->artisan('db:create')
            ->expectsQuestion('What is your name?', 'Taylor Otwell')
            ->expectsQuestion('Which language do you program in?', 'PHP')
            ->expectsOutput('Your name is Taylor Otwell and you program in PHP.')
            ->assertExitCode(0);
    }
}