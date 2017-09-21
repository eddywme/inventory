<?php

namespace App\Http\Controllers;

use App\ApiSubscription;
use App\Mail\ApiSubscriptionMail;
use App\User;
use App\Utility\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiSubscriptionController extends Controller
{
    public function index(){
        $apiSubscriptions = ApiSubscription::all();

        return view('api.api-users-list', [
            'apiSubscriptions' => $apiSubscriptions
        ]);
    }

    public function assignTokenGet(){
        return view('api.token-assignment-index');
    }

    public function sendTokenPost(Request $request){
        $user = User::all()->where('email', $request->get('email'))->first();
        if(!$user) {

            return response()->json([
                'message' => 'The user with that e-mail address does not exist in the system, Try again'
            ], 400);
        }

        $token = str_random(64);

        $isUserSubscribed = ApiSubscription::all()->where('user_id', $user->id)->count();

        if($isUserSubscribed > 0) {

            /* Update if the user is not a new subscriber */

            $apiSubscription = ApiSubscription::all()->where('user_id', $user->id)->first();

            $apiSubscription->token = $token;
            $apiSubscription->save();

        } else {
            /* Set new api subscriber  */
            $apiSubscription = new ApiSubscription();
            $apiSubscription->token = $token;
            $apiSubscription->issued_by = Utils::authUserId();
            $apiSubscription->user_id = $user->id;
            $apiSubscription->save();
        }






        Mail::to($user)
            ->send(new ApiSubscriptionMail($token, $user));


        sleep(1);

        return response()->json([
            'token' => $token,
            'message' => 'Token sent to the user email address successfully'
        ], 200);

    }
}
