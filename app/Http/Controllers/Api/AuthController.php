<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;




class AuthController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function SendVerificationCode(Request $request)
    {

        $verificationCode = rand(100000, 999999);
        session(['verification_code' => $verificationCode]);

        $response = $this->smsService->sendSms($request->phone, $verificationCode);

        return response()->json($response);
    }
}
