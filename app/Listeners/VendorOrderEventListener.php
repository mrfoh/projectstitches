<?php
namespace App\Listeners;

use Log;
use App\Models\Vendor;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorOrderEventListener implements ShouldQueue
{
    use DispatchesJobs;

    private function getDevices($users) {
        $devices = [];

        
    }

    private function sendNewOrderPushNotification($users, $order) {

        
    }

	public function onOrderCreated($event) {
		$order = $event->order;
        $vendor = Vendor::with('users')->find($order->vendor_id);

        Log::info('users', ['data' => $vendor->users]);
        
        //send push notification
        $this->sendNewOrderPushNotification($vendor->users, $order);

        //dispatch email notification job
	}

	/**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\VendorOrderCreated','App\Listeners\VendorOrderEventListener@onOrderCreated'
        );

    }
}