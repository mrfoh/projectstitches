<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\Transaction;

	class TransactionTransformer extends TransformerAbstract {

	    /**
	     * Transform model collection
	     * @param App\Models\Product $product
	     * @return League\Fractal\ItemCollection
	     */
		public function transform(Transaction $model)
	    {
	        return 
	        [
	        	'id' => $model->id,
	        	'ref' => $model->ref,
	        	'amount' => $model->amount,
	        	'verified' => (bool) $model->verified,
	        	'status' => $model->status,
	        	'created_at' => $model->created_at,
	        	'updated_at' => $model->updated_at  
	        ];
	    }
	}