<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OpServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opserve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run optimize and serve commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running config clear command...');
        $this->call('config:clear');

        $this->info('Running route clear command...');
        $this->call('route:clear');

        $this->info('Running route view command...');
        $this->call('view:clear');

        $this->info('Running optimize command...');
        $this->call('optimize');

        $this->info('Running serve command...');
        $this->call('serve');

        return Command::SUCCESS;
    }
}
