<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\Transformers\ProductTransformer;
	use App\Models\OrderItem;

	class OrderItemTransformer extends TransformerAbstract {

		/**
	     * List of resources to include by default
	     *
	     * @var array
	     */
	    protected $defaultIncludes = ['product'];

		/**
	     * Include Images
	     * @param App\Models\OrderIitem $item
	     * @return League\Fractal\ItemCollection
	     */
	    public function includeProduct(OrderItem $item)
	    {
	        $product = $item->product;

	        return $this->item($product, new ProductTransformer());
	    }

	    /**
	     * Transform model collection
	     * @param App\Models\Order $model
	     * @return League\Fractal\ItemCollection
	     */
		public function transform(OrderItem $model)
	    {
	        return 
	        [
	        	'id' => $model->id,
	        	'order_id' => $model->order_id,
	        	'qty' => $model->qty,
	        	'variant' => ($model->variant) ? [
	        		'name' => $model->variant->name,
	        		'value' => $model->variant->value
	        	] : NULL,
	        	'measurement' => ($model->measurement) ? [
	        		'id' => $model->measurement->id,
	        		'name' => $model->measurement->name
	        	] : NULL,
	        	'vendoritem' => $model->vendoritem,
	        	'created_at' => $model->created_at,
	        	'updated_at' => $model->updated_at  
	        ];
	    }
	}