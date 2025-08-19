<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\Promotor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dealer = Dealers::where('mobile', $request->mobile)->first();

        if (!$dealer) {
            return response()->json([
                'status' => false,
                'message' => 'Mobile number not found'
            ], 404);
        }

        $otp = rand(100000, 999999);

        $dealer->otp = $otp;
        $dealer->otp_expired_at = now()->addMinutes(5);
        $dealer->save();

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
            'otp' => $otp
        ]);
    }


    public function verifyOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $otp = Dealers::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if (!$otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        $dealer = Dealers::where('mobile', $request->mobile)->where('otp', $request->otp)->where('otp_expired_at', '>', now())->first();

        if (!$dealer) {
            return response()->json([
                'status' => false,
                'message' => 'OTP Expired'
            ], 400);
        }

        // $token = $dealer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'dealer' => $dealer
        ]);
    }
}
