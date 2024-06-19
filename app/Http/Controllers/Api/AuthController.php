<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Twilio\Rest\Client;

class AuthController extends Controller
{

    private function formatPhoneNumber($phoneNumber, $countryCode)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {

            $numberProto = $phoneUtil->parse($phoneNumber, $countryCode);

            $formattedPhoneNumber = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);

            return $formattedPhoneNumber;
        } catch (NumberParseException $e) {
            return $e;
        }
    }




    public function SendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $formatted = $this->formatPhoneNumber($request->phone, 'KZ');


        $verificationCode = rand(100000, 999999);


        session(['verification_code' => $verificationCode]);


        $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));



        try {
            $client->messages->create(
                $request->phone,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "ALMARAY: $verificationCode"
                ]
            );
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not send verification code'], 500);
        }

        return response()->json(['message' => 'Verification code sent']);
    }
}
