<?php
	namespace App\Models\Transformers;

	use League\Fractal\TransformerAbstract;
	use App\Models\Vendor;

	class VendorTransformer extends TransformerAbstract {

		public function transform(Vendor $model) {
		
			return [
				'id' => $model->id,
				'name' => $model->name,
				'logo' => $model->logo,
				'description' => $model->description,
				'segment' => $model->segment,
				'profile' => ($model->profile) ? [
					'profile_photo' => $model->profile->profile_photo,
					'phones' => $model->profile->phones,
					'addresses' => $model->profile->addresses,
					'facebook' => $model->profile->facebook,
					'twitter' => $model->profile->twitter,
					'instagram' => $model->profile->instagram
				] : null,
				'created_at' => $model->created_at,
				'updated_at' => $model->updated_at
			];
		}
	}