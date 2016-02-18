<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\VendorOrderItem;

	class VendorOrderItemTransformer extends TransformerAbstract {
	    /**
	     * Transform model collection
	     * @param App\Models\VendorOrderItem $model
	     * @return League\Fractal\ItemCollection
	     */
		public function transform(VendorOrderItem $model)
	    {
	        return 
	        [
	        	'id' => $model->id,
	        	'product' => [
	        		'id' => $model->item->product->id,
	        		'name' => $model->item->product->name,
	        		'price' => $model->item->product->price
	        	],
	        	'qty' => $model->item->qty,
	        	'variant' => $model->item->variant,
	        	'created_at' => $model->created_at,
	        	'updated_at' => $model->updated_at,  
	        ];
	    }
	}