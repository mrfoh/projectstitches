<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\Transformers\OrderTransformer;
	use App\Models\VendorOrder;

	class VendorOrderTransformer extends TransformerAbstract {

		/**
	     * List of resources to include by default
	     *
	     * @var array
	     */
	    protected $defaultIncludes = ['items'];

	    /**
	     * Include Images
	     * @param App\Models\VendorOrder $order
	     * @return League\Fractal\ItemCollection
	     */
	    public function includeItems(VendorOrder $order)
	    {
	        $items = $order->items;

	        return $this->collection($items, new VendorOrderItemTransformer());
	    }


	    /**
	     * Transform model collection
	     * @param App\Models\VendorOrder $model
	     * @return League\Fractal\ItemCollection
	     */
		public function transform(VendorOrder $model)
	    {
	    	$methods = [
	    		'pod' => 'Pay on delivery',
	    		'card' => 'Debit/Credit Card'
	    	];

	        return [
	        	'id' => $model->id,
	        	'no' => $model->no,
	        	'order' => [
	        		'id' => $model->order->id,
	        		'order_no' => $model->order->order_no,
	        		'total' => $model->order->total, 
	        		'user' => [
	        			'id' => $model->order->user->id,
	        			'name' => $model->order->user->first_name." ".$model->order->user->last_name,
	        			'address' => [
	        				'street' => $model->order->address->street,
	        				'city' => $model->order->address->city,
	        				'contact_phone' => $model->order->address->contact_phone,
	        				'contact_name' => $model->order->address->contact_name
	        			]
	        		],
	        		'paid' => (bool) $model->order->paid,
	        		'method' => $methods[$model->order->method]
	        	],
	        	'status' => $model->status,
	        	'created_at' => $model->created_at,
	        ];
	    }
	}