<?php

namespace Vkovic\LaravelCommando\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ScheduleRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Laravel scheduler to cron jobs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command = 'crontab -l | grep "' . base_path() . '/artisan schedule:run" | wc -l';
        $process = new Process($command);
        $process->run();

        $alreadyRegistered = (bool) trim($process->getOutput());

        if ($alreadyRegistered) {
            $this->info('Cron job already registered');
            return 1;
        }

        $command = '(crontab -l 2>/dev/null; echo "* * * * * php ';
        $command .= base_path() . '/artisan schedule:run >> /dev/null 2>&1") ';
        $command .= '| crontab -';
        $process = new Process($command);
        try {
            $process->run();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 0;
        }

        $this->info('Cron job registered successfully');
        return 1;
    }
}