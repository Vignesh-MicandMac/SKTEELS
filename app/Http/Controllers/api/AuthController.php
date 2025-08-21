<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\Executive;
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
        $otp = rand(100000, 999999);

        if ($dealer) {

            $dealer->otp = $otp;
            $dealer->otp_expired_at = now()->addMinutes(5);
            $dealer->save();

            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully to the Dealer',
                'otp' => $otp
            ]);
        } else {

            $executive = Executive::where('mobile', $request->mobile)->first();

            if ($executive) {
                $executive->otp = $otp;
                $executive->otp_expired_at = now()->addMinutes(5);
                $executive->save();

                return response()->json([
                    'status' => true,
                    'message' => 'OTP sent successfully to the Executive',
                    'otp' => $otp
                ]);
            } else {

                return response()->json([
                    'status' => false,
                    'message' => 'No Dealer or Executive found with this mobile number.'
                ], 404);
            }
        }
    }


    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => [
                'required',
                'digits:10',
                function ($attribute, $value, $fail) {
                    $exists = Dealers::where('mobile', $value)->exists() ||
                        Executive::where('mobile', $value)->exists();

                    if (!$exists) {
                        $fail('The mobile number does not exist in our records.');
                    }
                },
            ],
            'otp'    => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $dealer = Dealers::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if ($dealer) {

            if ($dealer->otp_expired_at < now()) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP Expired'
                ], 400);
            }


            return response()->json([
                'status' => true,
                'message' => 'Dealer login successful',
                'user_type' => 'dealer',
                'dealer' => $dealer
            ]);
        }

        $executive = Executive::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if ($executive) {

            if ($executive->otp_expired_at < now()) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP Expired'
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Executive login successful',
                'user_type' => 'executive',
                'executive' => $executive
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ], 400);
    }
}
