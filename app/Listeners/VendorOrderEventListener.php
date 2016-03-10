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

    private function getDevices($users) {
        $devices = [];

        foreach($users as $user) {
            if(!is_null($user->gcm_token)) {
                $devices[] = Push::Device($user->gcm_token, [
                    'title' => "New Order",
                    'body' => "New order recieved"
                ]);
            }
        }

        return $devices;
    }

    private function sendNewOrderPushNotification($users, $order) {

        $devices = $this->getDevices($users);

        if(count($devices) < 1) {
            return false;
        }

        $recievers = Push::DeviceCollection($devices);

        $message = Push::Message('Order', array(
            'data' => [
                'id' => $order->id,
                'no' => $order->no,
                'total' => $order->total,
                'placed_at' => $order->created_at
            ]
        ));

        $collection = Push::app('appNameAndroid')->to($recievers)->send($message);
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