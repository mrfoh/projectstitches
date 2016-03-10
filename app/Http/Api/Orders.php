<?php
	namespace App\Http\Api;

	use App\Http\Controllers\Controller;
	use App\Http\Api\Traits\RequestUser;
	use App\Repos\OrderRepo;
	use App\Repos\TransactionRepo;
	use App\Repos\Traits\Pageable;
	use Illuminate\Http\Request;

	class Orders extends Controller {

		use RequestUser, Pageable;

		protected $repo;

		protected $transactions;

		public function __construct(OrderRepo $repo, TransactionRepo $transactions) {
			$this->middleware('jwt.auth');
			$this->repo = $repo;
			$this->transactions = $transactions;
		}
		
		public function index() {

		}

		public function get($no) {

			$models = $this->repo->scopeQuery(function ($query) use ($no) {
				return $query->where('order_no','=', $no);
			})->all();

			return $models;
		}

		public function user(Request $request, $id) {

			$sortBy = $request->input('sort_by','created_at');
			$sortOrder = $request->input('sort_order','desc');

			$perPage = $request->input('per_page', 20);
			$page = $request->input('page', 1);

			$orders = $this->repo->scopeQuery(function ($query) use ($id, $sortBy, $sortOrder) {
				return $query->where('user_id','=', $id)
							 ->orderBy($sortBy, $sortOrder);
			})->all();

			return $this->paginateData($orders['data'], count($orders['data']), $page, $perPage);
		}

		/**
		 * Create Order
		 * @param Illuminate\Http\Request $request
		*/
		public function create(Request $request) {
			$this->validate($request, [
				'cart' => 'required|array',
				'paid' => 'required',
				'method' => 'required|in:card,pod',
				'address' => 'required',
				'ref' => 'exists:transactions,ref'
			]);

			$items = $request->input('cart');

			$user = $this->requestUser();

			$address = $request->input('address');

			$method = $request->input('method');

			$paid = $request->input('paid');

			$ref = $request->input('ref');

			$order = $this->repo->make($items, $user, $paid, $method, $address);

			if(!is_null($ref)) {
				$this->transactions->associateOrder($ref, $order['data']['id']);
			}

			//fire OrderCreated event
			
			return $order;
		}
	}