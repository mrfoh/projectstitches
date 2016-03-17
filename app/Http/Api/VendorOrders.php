<?php

	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use App\Repos\VendorOrderRepo;
	use App\Repos\VendorOrderItemRepo;
	use App\Repos\Traits\Pageable;
	use Illuminate\Http\Request;

	class VendorOrders extends Controller {

		use Pageable, RequestUser;

		protected $repo;

		protected $items;

		public function __construct(VendorOrderRepo $repo, VendorOrderItemRepo $itemRepo) {
			$this->middleware('jwt.auth');
			$this->repo = $repo;
			$this->items = $itemRepo;
		}

		public function get($vendor_id, $order_id) {

			return $this->repo->find($order_id);
		}

		public function update(Request $request, $vendor_id, $order_id) {

			$order = $this->repo->skipPresenter()->find($order_id);

			//validate request
			$this->validate($request, [
				'status' => 'in:pending,cancelled,shipped,delivered'
			]);

			$attributes = $request->all();

			$update = $this->repo->skipPresenter(false)->update($attributes, $order_id);

			return $update;
		}

		public function updateItem(Request $request, $vendor_id, $order_id, $item_id) {

			$order = $this->repo->skipPresenter()->find($order_id);

			//validate request
			$this->validate($request, [
				'status' => 'in:pending,cancelled,shipped,delivered,tailoring'
			]);

			$attributes = $request->all();

			$update = $this->items->skipPresenter(false)->update($attributes, $item_id);

			return $update;
		}	
	}
