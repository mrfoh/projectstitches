<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PushNotification;

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
        $deviceRegistrationId = "APA91bE-EjWoVrM05LSzkWj9EjDJeOOVbwl9-4TB0pjbwXtfSRyL7QjUDC7zkJIr3bWzdvRyiBPhY8JlliYeuJ_Pky9s_MfQZppa9zYEaXHCfHlJ_QdX0Db9HUaPSxi0Jz0Cery1lORW";
        
        $devices = PushNotification::DeviceCollection([
            PushNotification::Device($deviceRegistrationId)
        ]);

        $message = PushNotification::Message('Order recieved', [
            'title' => 'Stitches Vendor',
            'data' => [
                'no' => "kngkaglkngla"
            ]
        ]);

        $collection = PushNotification::app('stitches')->to($devices)->send($message);
    }
}
