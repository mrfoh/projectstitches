<?php
namespace App\Listeners;

use Log;
use PushNotification;
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
                $devices[] = PushNotification::Device($user->gcm_token);
            }
        }

        return $devices;
    }

    private function sendNewOrderPushNotification($users, $order) {

        $recievers = PushNotification::DeviceCollection($this->getDevices($users));

        $message = PushNotification::Message('Order Recieved', [
            'title' => 'Stitches Vendor',
            'data' => [
                'id' => $order->id,
                'no' => $order->no,
                'total' => $order->total
            ]
        ]);

        $collection = PushNotification::app('stitches')->to($recievers)->send($message);

        // get response for each device push
        foreach ($collection->pushManager as $push) {
            $response = $push->getAdapter()->getResponse();
            Log::info('GCM Response', ['response' => $response]);
        }
    }

	public function onOrderCreated($event) {
		$order = $event->order;
        $vendor = Vendor::with('users')->find($order->vendor_id);
        
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