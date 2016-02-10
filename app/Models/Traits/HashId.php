<?php
	namespace App\Models\Traits;

	use App\Utils\ID;

	trait HashId {

		/**
		 * Returns and encode hash id value
		 *
		 * @return string
		 */
		public function getIdAttribute($value)
		{
		    return ID::encode($value);
		}
	}