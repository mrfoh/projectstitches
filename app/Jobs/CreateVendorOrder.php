<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Container\Container as Application;
use App\Repos\VendorOrderRepo;
use App\Models\Order;

class CreateVendorOrder extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $order;

    protected $repo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->repo = new VendorOrderRepo(new Application());
    }

    private function getOrderVendors() {

        $vendors = [];

        foreach($this->order->items as $item) {
            $vendors[] = $item->vendor_id;
        }

        return array_unique($vendors, SORT_NUMERIC);
    }

    private function getOrderTotal($items, $vendor) {

        $total = 0;

        foreach($items as $item) {
            if($item->vendor_id == $vendor) {
                $total = $total + $item->product->price;
            }
        }

        return $total;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get all vendors from cart items
        $vendorIds = $this->getOrderVendors();
        //vendor orders
        $vendorOrders = [];
        //vendor order iems
        $vendorOrderItems = [];

        //Create vendor orders
        foreach($vendorIds as $vendorId) 
        {
            $vendorOrders[] = [
                'vendor_id' => $vendorId,
                'order_id' => $this->order->id,
                'total' => $this->getOrderTotal($this->order->items, $vendorId)
            ];
        }

        $orders = $this->repo->makeMany($vendorOrders);

        foreach($orders as $key => $order) {
            foreach($this->order->items as $item) {
                if($item->vendor_id == $order->vendor_id) {
                    $vendorOrderItems[] = [
                        'vendor_order_id' => $order->id,
                        'order_item_id' => $item->id
                    ];
                }
            }
        }

        $this->repo->addItems($vendorOrderItems);
    }
}
