<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class OrderItemStatusUpdate extends Event
{
    use SerializesModels;
    
    public $item;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }
}
