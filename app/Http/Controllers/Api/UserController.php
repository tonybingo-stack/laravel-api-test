<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Carbon\Carbon;
use App\Models\User;

class UserController extends Controller
{

    public function signIn(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        if ($request->has('email')) {
            $rules['email'] = 'required|email';
        }

        $rules['password'] = 'required|min:8';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorResponse = validation_error_response($validator->errors()->toArray());
            return response()->json($errorResponse, STATUS_BAD_REQUEST);
        }

        $requestData = $request->all();

        $checkUser = User::login($request->all());


        if (!isset($checkUser['user'])) {
            $response['message'] = $checkUser['message'];
            $response['status'] = STATUS_UNAUTHORIZED;
            return $response;
        }

        try {
            $user = $checkUser['user'];
            // Update device token
            $userObj = User::where('id', $user->id)->first();

            $token = $user->createToken($user->id . ' token ')->accessToken;

            $userObj->token = $token;
            $response['success'] = TRUE;
            $response['message'] = "Login successfully";
            $response['data'] = $userObj;
            $response['code'] = 0;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    public function logout(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $userId = $request->user()->id;
            $userObj = User::find($userId);
            $userObj->save();
            $user = Auth::user()->token();
            $user->revoke();
            $response['message'] = 'Logout successfully';
            $response['success'] = TRUE;
            $response['status'] = STATUS_OK;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }

    public function profileDetail(Request $request)
    {
        $response = [];
        $response['success'] = FALSE;

        try {
            $requestData = $request->all();
            $userId = $requestData['profile_id'] ?? $request->user()->id;
            $userObj = User::find($userId);
            $response['data'] = $userObj;
            $response['message'] = 'Profile detail fetched successfully';
            $response['code'] = 0;
            $response['status'] = STATUS_OK;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage() . ' Line No ' . $e->getLine() . ' in File' . $e->getFile();
            Log::error($e->getTraceAsString());
            $response['status'] = STATUS_GENERAL_ERROR;
        }

        return response()->json($response, $response['status']);
    }
}
