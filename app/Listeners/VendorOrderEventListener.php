<?php
namespace App\Listeners;

use Push;
use Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class VendorOrderEventListener implements ShouldQueue
{
	public function onOrderCreated($event) {
		$order = $event->order;

		Log::debug('Order Created Event Fired');
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