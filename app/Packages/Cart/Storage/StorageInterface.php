<?php
	
	namespace App\Packages\Cart\Storage;

	interface StorageInterface {
		public function get();
	    public function put($key, $data);
	    public function update($key, $quantity);
	    public function delete($key);
	    public function destroy();
	}