<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\Transformers\OrderTransformer;
	use App\Models\Order;

	class OrderTransformer extends TransformerAbstract {

		/**
	     * List of resources to include by default
	     *
	     * @var array
	     */
	    protected $defaultIncludes = ['items'];

	    /**
	     * Include Images
	     * @param App\Models\Order $order
	     * @return League\Fractal\ItemCollection
	     */
	    public function includeItems(Order $order)
	    {
	        $items = $order->items;

	        return $this->collection($items, new OrderItemTransformer());
	    }


	    /**
	     * Transform model collection
	     * @param App\Models\Order $model
	     * @return League\Fractal\ItemCollection
	     */
		public function transform(Order $model)
	    {
	        return 
	        [
	        	'id' => $model->id,
	        	'order_no' => $model->order_no,
	        	'total' => $model->total,
	        	'paid' => $model->paid,
	        	'method' => $model->method,
	        	'created_at' => $model->created_at,
	        	'updated_at' => $model->updated_at  
	        ];
	    }
	}