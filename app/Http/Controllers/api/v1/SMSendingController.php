<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Nexmo\Laravel\Facade\Nexmo;

class SMSendingController extends Controller
{
    public function sendSMS(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255',
            'origin_phone_number' => 'required|string',
            'destination_phone_number' => 'required|string',

            'token' => 'required|string',

        ]);


        if ($validator->fails()) {

            $errors['errors'] = $validator->errors()->all();
            return response()->json($errors, 400) ;
        }

        $message = $request->get('message');
        $origin_phone_number = $request->get('origin_phone_number');
        $destination_phone_number = $request->get('destination_phone_number');

        $nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
            'to' => $destination_phone_number,
            'from' => $origin_phone_number,
            'text' => $message
        ]);

        return response()->json([
            'message' => 'SMS sent successfully'
        ], 200) ;

    }
}
