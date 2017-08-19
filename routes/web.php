
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


//Serving Images
//Route::get('storage/app/public/items-images/{filename}', function ($filename)
//{
//
//    $path = storage_path('app/public/items-images/' . $filename);
//
//    if (!File::exists($path)) {
//        abort(404);
//    }
//
//    $file = File::get($path);
//    $type = File::mimeType($path);
//
//    $response = Response::make($file, 200);
//    $response->header("Content-Type", $type);
//
//    return $response;
//
//});


