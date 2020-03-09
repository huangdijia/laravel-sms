<?php

namespace Huangdijia\Sms\Console;

use Illuminate\Console\Command;
use Huangdijia\Sms\SmsServiceProvider;

class InstallCommand extends Command
{
    protected $signature   = 'sms:install';
    protected $description = 'Install Package';

    public function handle()
    {
        $this->info('Installing Package...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => SmsServiceProvider::class,
            '--tag'      => "config",
        ]);

        $this->info('Installed Package');
    }
}