<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class VendorOrderCreated extends Event
{
    use SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
}
