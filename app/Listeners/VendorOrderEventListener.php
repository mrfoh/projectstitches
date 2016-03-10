<?php
namespace App\Listeners;

use Push;
use Log;
use App\Models\Vendor;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorOrderEventListener implements ShouldQueue
{
    use DispatchesJobs;

	public function onOrderCreated($event) {
		$order = $event->order;
        $vendor = Vendor::with('users')->find($order->vendor_id);
        Log::info('users', ['data' => $vendor->users]);
        /*send push notification
        Push::app('appNameAndroid')
            ->to($vendorUsers[0]->gcm_token)
            ->send("Order Recieved");*/

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