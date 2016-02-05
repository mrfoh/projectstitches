<?php
/*
* Api Endpoints
*/
Route::group(['prefix' => "api"], function() {

	//Accounts
	Route::group(['prefix' => "accounts"], function() {

		Route::post('auth', 'Accounts@auth');
		Route::post('create', 'Accounts@create');
		Route::post('changepassword', 'Accounts@changePassword');
		Route::get('logout', 'Accounts@logout');
	});

	//Addresses
	Route::group(['prefix' => "addresses"], function() {

		Route::get('{id}/default', 'Addresses@makeDefault');
		Route::put('{id}', 'Addresses@update');
		Route::get('{id}', 'Addresses@read');
		Route::delete('{id}', 'Addresses@delete');
	});

	//Carts
	Route::group(['prefix' => "cart"], function() {

		Route::delete('{rowid}', 'Carts@remove');
		Route::get('/', 'Carts@get');
		Route::post('/', 'Carts@put');
	});

	//Categories
	Route::group(['prefix' => "categories"], function() {

		Route::get('{id}/products', 'Categories@products');
		Route::delete('{id}', 'Categories@delete');
		Route::put('{id}', 'Categories@update');
		Route::get('{id}', 'Categories@get');
		Route::post('/', 'Categories@create');
		Route::get('/', 'Categories@index');
	});

	//Orders
	Route::group(['prefix' => "orders"], function() {
	});

	Route::any('media/upload', 'Media@upload');
	Route::get('media', 'Media@index');

	Route::group(['prefix' => "products"], function() {

		Route::delete('{id}/variants/{vid}', 'Variants@delete');
		Route::put('{id}/variants/{vid}', 'Variants@update');
		Route::post('{id}/variants', 'Variants@create');
		Route::get('{id}/variants', 'Variants@get');

		Route::delete('{id}/media/{mid}', 'Products@deleteMedia');
		Route::post('{id}/media', 'Products@addMedia');
		
		Route::delete('{id}', 'Products@delete');
		Route::put('{id}', 'Products@update');
		Route::get('{id}', 'Products@get');
		Route::post('/', 'Products@create');
		Route::get('/', 'Products@index');
	});

	//Users
	Route::group(['prefix' => "users"], function() {

		Route::post('{id}/addresses', 'Addresses@create');
		Route::get('{id}/addresses', 'Addresses@user');
		Route::put('{id}/profile', 'Users@update');
	});

	//Vendors
	Route::group(['prefix' => "vendors"], function() {

		Route::get('{id}/orders', 'Vendors@orders');
		Route::get('{id}/products', 'Vendors@products');
		Route::post('{id}/logo', 'Vendors@uploadLogo');

		Route::put('{id}', 'Vendors@update');
		Route::get('{id}', 'Vendors@index');
		Route::post('/', 'Vendors@create');
		Route::get('/', 'Vendors@index');
	});
});