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

	//Campaigns
	Route::group(['prefix' => "campaigns"], function() {

		Route::post('{id}/images', 'Campaigns@upload');
		Route::put('{id}', 'Campaigns@update');
		Route::post('/', 'Campaigns@create');
		Route::get('/', 'Campaigns@index');
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

		Route::get('{no}', 'Orders@get');
		Route::post('/', 'Orders@create');
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

		Route::get('{id}/measurements/{mid}', 'UserMeasurements@get');
		Route::delete('{id}/measurements/{mid}', 'UserMeasurements@delete');
		Route::put('{id}/measurements/{mid}', 'UserMeasurements@update');
		Route::post('{id}/measurements', 'UserMeasurements@create');
		Route::get('{id}/measurements', 'Users@measurements');

		Route::get('{id}/orders', 'Orders@user');

		Route::post('{id}/addresses', 'Addresses@create');
		Route::get('{id}/addresses', 'Addresses@user');

		Route::put('{id}/profile', 'Users@update');
	});

	//Transactions
	Route::group(['prefix' => "transactions"], function() {

		Route::get('completed', 'Transactions@completed');
		Route::put('{ref}', 'Transactions@update');
		Route::post('/', 'Transactions@create');
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