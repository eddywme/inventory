
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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/',
function () {
		return view('home');
	});
/* Temp Work-around */
Route::get('/home', function () {
		return redirect('/');
	});

Auth::routes();

/* Json search data endpoint */
Route::get('search_data', [
		'uses' => 'HomeController@search_data',
	]);

Route::resource('items', 'ItemController');

Route::get('item-categories/{slug}/items', 'ItemCategoryController@showCategoryItems')
	->name('item-categories.showCategoryItems');

/* Item Accessory Related Routes */

Route::get('accessories/{slug}', 'ItemAccessoryController@show')
	->name('item-accessories.show');

Route::get('item', [
		'uses' => 'ItemController@search',
		'as'   => 'items.search',
	]);

/*Testing Mails */
/*
Route::get('/con-email', function (){

$item = Item::all()->first();
$user = User::all()->first();

return view('emails.request-accepted')
->with([
'item' => $item,
'user' => $user
]);

});

Route::get('/to-assigned', function(){

$user = User::all()->first();

return view('emails.to-assigned-user')
->with([
'user'  => $user,
'message_text'  => "While the publisher and the author have used good faith efforts to ensure that the information
and instructions contained in this work are accurate, the publisher and the author disclaim all
responsibility for errors or omissions, including without limitation responsibility for
damages resulting from the use of or reliance on this work. Use of the information and
instructions contained in this work is at your own risk. If any code samples or other"
]);
});*/

Route::group(['middleware' => ['auth']], function () {

		/* Only authenticated users can send  Item Requests  */
		Route::get('/items/{slug}/request', 'ItemRequestController@requestIndex')
			->name('request.index');

		Route::post('/items/{slug}/request', 'ItemRequestController@requestPost')
			->name('request.post');

		/* Make the item available */
		Route::get('/requests/{itemRequestId}/reject', 'ItemRequestController@rejectRequest')
			->name('request.reject');

		/* Users related routes */
		Route::resource('users', 'UserController');

		Route::get('/manage-roles', 'UserController@manageRolesIndex')
            ->name('manage.roles.index');

    Route::post('/assign-role', 'UserController@assignRole')
        ->name('assign.role.post');


    Route::group(['middleware' => ['sys.personnel']], function () {

				/* Item accessories*/
				Route::put('items/accessories/{itemAccessorySlug}', 'ItemAccessoryController@update')
					->name('item-accessories.update');

                Route::delete('items/accessories/{itemAccessorySlug}', 'ItemAccessoryController@destroy')
                ->name('item-accessories.destroy');

				Route::post('items/accessories/', 'ItemAccessoryController@store')
					->name('item-accessories.store');

				Route::get('items/accessories/create', 'ItemAccessoryController@create')
					->name('item-accessories.create');

				Route::get('items/accessories/{itemAccessorySlug}/edit', 'ItemAccessoryController@edit')
					->name('item-accessories.edit');

				/* Rest Routes End-points*/
				Route::get('/assignment/firstNamesEndPoint', 'ItemAssignmentController@firstNamesEndPoint');
				Route::get('/assignment/lastNamesEndPoint', 'ItemAssignmentController@lastNamesEndPoint');
				Route::get('/assignment/emailsEndPoint', 'ItemAssignmentController@emailsEndPoint')
					->name('emails.endpoint');

				/*  Admin routes*/
				Route::group(['prefix' => 'admin'], function () {

						Route::get('/', 'AdminController@index');

						Route::get('items-all', 'ItemController@adminIndex')
							->name('items-admin');

						Route::get('items-accessories', 'ItemAccessoryController@index')
							->name('item-accessories');

						/* Item categories */
						Route::resource('item-categories', 'ItemCategoryController');

						Route::get('/item-assignments', 'ItemAssignmentController@assignmentList')
							->name('assign.list');

						/* Prepare an e-mail to send to the user when the request is approved  */
						Route::get('/item-request/{requestId}/accept', 'ItemRequestController@requestResponseAccepted')
							->name('request-response-accepted');
						/* The List Of Item Requests*/
						Route::get('/item-requests', 'ItemRequestController@requestList')
							->name('request.list');

						Route::get('/item-requests/{itemRequestId}', 'ItemRequestController@show')
							->name('request.show');

						/* Item Assignment */
						Route::get('/items/{slug}/assign', 'ItemAssignmentController@assignIndex')
							->name('assign.index');

						Route::get('/items/{itemSlug}/assign-to-reserved/{userSlug}', 'ItemAssignmentController@assignIndexToReserved')
							->name('assign-to-reserved.index');

						Route::post('/items/{slug}/assign', 'ItemAssignmentController@assignPost')
							->name('assign.post');

						Route::get('/items-assignments/{assignmentId}/return-item', 'ItemAssignmentController@assignReturnGet')
							->name('assign.return.get');

						Route::post('/items-assignments/{assignmentId}/return-item', 'ItemAssignmentController@assignReturnPost')
							->name('assign.return.post');

						/* Prepare an e-mail to send to the user */
						Route::get('/item-assignments/{assignmentId}/mail', 'ItemAssignmentController@sendMailToAssignedGet')
							->name('assign.email.get');
						/* send E-mail to the user */
						Route::post('/item-assignments/{assignmentId}/send-mail', 'ItemAssignmentController@sendMailToAssignedPost')
							->name('send.email.toAssigned');

						/* Prepare an SMS to send to the user */
						Route::get('/item-assignments/{assignmentId}/sms', 'ItemAssignmentController@sendSMSToAssignedGet')
							->name('assign.sms.get');

						/* send SMS to the user */
						Route::post('/item-assignments/{assignmentId}/send-sms', 'ItemAssignmentController@sendSMSToAssignedPost')
							->name('send.sms.toAssigned');

						/* Token Assignment & API users management */
						Route::get('/api', 'ApiSubscriptionController@index')
							->name('api.index');

						Route::get('/token-assignment', 'ApiSubscriptionController@assignTokenGet')
							->name('assignToken.get');

						Route::post('/token-assignment', 'ApiSubscriptionController@sendTokenPost')
							->name('sendToken.post');

					});
			});

	});
