
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

/* Json search data endpoint */
Route::get('search_data', [
    'uses' => 'HomeController@search_data',
]);

/*  Admin routes*/
Route::group(['prefix'	=>	'admin', 'middleware' => 'auth'], function()	{
    Route::get('/', 'AdminController@index');

});

Route::resource('users', 'UserController');

Route::resource('items', 'ItemController');
Route::get('items-admin', 'ItemController@adminIndex')
->name('items-admin');

Route::resource('item-categories', 'ItemCategoryController');
Route::get('item-categories/{slug}/items', 'ItemCategoryController@showCategoryItems')
->name('item-categories.showCategoryItems');

/* Item Accessory Related Routes */
Route::get('accessories', 'ItemAccessoryController@index')
    ->name('item-accessories');

Route::get('accessories/{slug}', 'ItemAccessoryController@show')
    ->name('item-accessories.show');

Route::get('items/{itemSlug}/accessories/create', 'ItemAccessoryController@create')
->name('item-accessories.create');

Route::post('items/{itemSlug}/accessories/', 'ItemAccessoryController@store')
    ->name('item-accessories.store');


Route::get('item', [
    'uses' => 'ItemController@search',
    'as' => 'items.search',
]);


