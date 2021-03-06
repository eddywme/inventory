<?php

namespace App\Http\Controllers\api\v1;

use App\ApiSubscription;
use App\Mail\MailToAssignedMD;
use App\Mail\RestServiceMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailSendingController extends Controller
{
    public function sendMail(Request $request){

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255',
            'subject' => 'required|string',
            'email_from' => 'required|email',
            'email_to' => 'required|email',

            'token' => 'required|string',

            'footer' => 'nullable|string',
            'header' => 'nullable|string'
        ]);


        if ($validator->fails()) {

            $errors['errors'] = $validator->errors()->all();
            return response()->json($errors, 400) ;
        }

        $user = ApiSubscription::all()->where('token', $request->get('token'))->first();

        if(!$user) {
            return response()->json([
                'message' => 'Invalid Token',
                'meta' => [
                    'status' => 'INVALID_TOKEN'
                ]
            ], 403) ;
        }



        $message_text = $request->get('message');
        $subject = $request->get('subject');
        $origin_address = $request->get('email_from');
        $destination_address = $request->get('email_to');

        $header_text = $request->get('footer');
        $footer_text = $request->get('header');

        Mail::to($destination_address)->queue(
            new RestServiceMail($subject, $message_text, $origin_address, $destination_address, $header_text, $footer_text ));


        return response()->json([
            'message' => 'E-mail sent successfully'
        ], 200) ;


    }
}
