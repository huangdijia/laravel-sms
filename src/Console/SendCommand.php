<?php

namespace Huangdijia\Sms\Console;

use Exception;
use Huangdijia\Sms\Facades\Sms;
use Illuminate\Console\Command;

class SendCommand extends Command
{
    protected $signature   = 'sms:send {to : Phone number, split by ,} {content : Message content} {-d|--driver=}';
    protected $description = 'Send message';

    public function handle()
    {
        if (!$to = $this->argument('to')) {
            $this->error('to is empty!');
            return;
        }

        if (!$content = $this->argument('content')) {
            $this->error('content is empty!');
            return;
        }

        $driver = $this->option('driver') ?? $this->laravel['config']['sms.defalut'] ?? 'local';

        try {
            Sms::driver($driver)->to($to)->content($content)->send()->throw();
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('Sent success!');
    }
}
