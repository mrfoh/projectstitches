<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utils\GCMPush;

class PushTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test push notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $gcm = new GCMPush();
        $gcm->addRegistrationId('APA91bE-EjWoVrM05LSzkWj9EjDJeOOVbwl9-4TB0pjbwXtfSRyL7QjUDC7zkJIr3bWzdvRyiBPhY8JlliYeuJ_Pky9s_MfQZppa9zYEaXHCfHlJ_QdX0Db9HUaPSxi0Jz0Cery1lORW');
        $gcm->addData('title', 'Test Notification');
        $gcm->addData('message', 'This is a test notification');
        $gcm->setCollapseKey('testing');
        $response = $gcm->push("vendor");

        dd($response);      
    }
}
