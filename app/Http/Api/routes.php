<?php
/*
* Api Endpoints
*/
Route::group(['prefix' => "api"], function() {

	//Accounts
	Route::group(['prefix' => "accounts"], function() {

		Route::post('auth', 'Accounts@auth');
		Route::post('create', 'Accounts@create');
		Route::get('logout', 'Accounts@logout');
	});

	//Carts
	Route::group(['prefix' => "cart"], function() {

		Route::delete('{rowid}', 'Carts@remove');
		Route::get('/', 'Carts@get');
		Route::put('/', 'Carts@put');
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

		//Route::get('{id}/cart', 'Carts@user');
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