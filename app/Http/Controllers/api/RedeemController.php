<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotor;
use App\Models\PromotorRedeemedGifts;
use App\Models\PromotorRedeemProduct;
use App\Models\PromotorSaleEntry;
use App\Models\SiteEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RedeemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gifts = Product::select('id', 'product_name', 'product_code', 'description', 'img_path', 'points', 'availability')
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($gift) {
                $gift->img_path = asset('storage/' . $gift->img_path);
                return $gift;
            });

        if ($gifts->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Gift Not found for this Promotor Id',
                'data' => $gifts,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Gifts fetched successfully',
            'data' => $gifts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promotor_id' => 'required|integer|exists:promotors,id',
            // 'executive_id' => 'required|integer|exists:executives,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $promotor_sites = SiteEntry::where('promotor_id', $request->promotor_id)->whereNull('deleted_at')->get()
            ->map(function ($promotor_sites) {
                $promotor_sites->img = asset('storage/' . $promotor_sites->img);
                return $promotor_sites;
            });

        if ($promotor_sites->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Sites Not found',
                'data' => $promotor_sites,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Promotor Sites Fetched successfully',
            'data' => $promotor_sites,
        ], 200);
    }

    public function executive_sites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'promotor_id' => 'required|integer|exists:promotors,id',
            'executive_id' => 'required|integer|exists:executives,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $executive_sites = SiteEntry::where('executive_id', $request->executive_id)->whereNull('deleted_at')->get()
            ->map(function ($executive_sites) {
                $executive_sites->img = asset('storage/' . $executive_sites->img);
                return $executive_sites;
            });

        if ($executive_sites->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Sites Not found',
                'data' => $executive_sites,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Executive Sites Fetched successfully',
            'data' => $executive_sites,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promotor_id' => 'required|exists:promotors,id',
            'dealer_id' => 'nullable|exists:dealers,id',
            'executive_id' => 'nullable|exists:executives,id',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;

        if ($request->hasFile('product_img')) {
            $file = $request->file('product_img');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = public_path('storage/uploads/promotor_redeemed_gifts');

            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            $file->move($path, $filename);

            $imagePath = 'uploads/promotor_redeemed_gifts/' . $filename;

            $record = PromotorRedeemedGifts::create([
                'promotor_id' => $request->promotor_id,
                'dealer_id' => $request->dealer_id,
                'executive_id' => $request->executive_id,
                'product_img' => $imagePath,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Promotor Redeemed product created successfully',
                'data' => $record,
            ], 200);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'promotor_id' => 'required|integer|exists:promotors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $promotor_redeemed_gifts = PromotorRedeemedGifts::where('promotor_id', $request->promotor_id)
            ->whereNull('deleted_at')
            ->select('id', 'promotor_id', 'dealer_id', 'executive_id', 'product_img')
            ->get()
            ->map(function ($gift) {
                $gift->product_img = asset('storage/' . $gift->product_img);
                return $gift;
            });

        if ($promotor_redeemed_gifts->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Gifts Not found for this Promotor Id',
                'data' => $promotor_redeemed_gifts,
            ], 200);
        }
        return response()->json([
            'status' => true,
            'message' => 'Promotor Redeemed product Fetched successfully',
            'data' => $promotor_redeemed_gifts,
        ], 200);
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

    public function points_based_gifts(Request $request)
    {
        $promotor = Promotor::where('id', $request->promotor_id)->whereNull('deleted_at')->first();

        if (!$promotor) {
            return response()->json(['status' => false, 'message' => 'Promotor not found']);
        }

        $availablePoints = (int)$promotor->points;

        $products = Product::where('points', '<=', $availablePoints)
            ->whereNull('deleted_at')
            ->where('availability', "1")
            ->select('id', 'product_name', 'product_code', 'description', 'img_path', 'points')
            ->get()
            ->map(function ($product) {
                $product->img_path = asset('storage/' . $product->img_path);
                return $product;
            });

        if ($products->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Gift Products Not found for this Promotor Id',
                'data' => $products,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Promotors Gift Products fetched successfully',
            'promotor_current_points' => $availablePoints,
            'data' => $products,
        ]);
    }

    public function redeem_send_otp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'promotor_id' => 'required|exists:promotors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $promotor = Promotor::where('id', $request->promotor_id)->whereNull('deleted_at')->first();

        if (!$promotor) {
            return response()->json(['status' => false, 'message' => 'Promotor not found'], 404);
        }

        $otp = rand(100000, 999999);
        $promotor->otp = $otp;
        $promotor->otp_generated_at = now();
        $promotor->save();

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully to the Promotor',
            'otp' => $otp
        ]);
    }

    public function redeem_verify_otp(Request $request)
    {
        //request dealer id , executive id , promotor id , product id
        $validator = Validator::make($request->all(), [
            'promotor_id' => 'required|exists:promotors,id',
            'dealer_id' => 'required|exists:dealers,id',
            'product_id' => 'required|exists:products,id',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $promotor = Promotor::where('id', $request->promotor_id)->whereNull('deleted_at')->first();
        $product = Product::where('id', $request->product_id)->whereNull('deleted_at')->first();

        if (!$promotor) {
            return response()->json(['status' => false, 'message' => 'Promotor not found'], 404);
        }

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        if ($promotor->otp != $request->otp) {
            return response()->json(['status' => false, 'message' => 'Invalid OTP'], 400);
        }

        if (now()->diffInMinutes($promotor->otp_generated_at) > 5) {
            return response()->json(['status' => false, 'message' => 'OTP expired'], 400);
        }

        // $promotor->otp = null;
        // $promotor->otp_generated_at = null;
        // $promotor->save();
        if ($promotor->points >= $product->points) {

            $promotor_redeem_product = new PromotorRedeemProduct();
            $promotor_redeem_product->dealer_id = $request->dealer_id ?? NULL;
            $promotor_redeem_product->executive_id = $request->executive_id ?? NULL;
            $promotor_redeem_product->promotor_id = $request->promotor_id;
            $promotor_redeem_product->product_id = $request->product_id;
            $promotor_redeem_product->product_code = $product->product_code ?? NULL;
            $promotor_redeem_product->product_name = $product->product_name ?? NULL;
            $promotor_redeem_product->redeemed_date = now();
            $promotor_redeem_product->promotor_points = $promotor->points ?? NULL;

            $promotor_redeem_product->product_redeem_points = $product->points ?? NULL;
            $promotor_redeem_product->balance_promotor_points = $promotor->points - $product->points;
            $promotor_redeem_product->approved_status = '0';
            $promotor_redeem_product->save();

            $promotor->update([
                'points' => $promotor->points - $product->points
            ]);

            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully and sale entry created',
                'data' => $promotor_redeem_product ?? [],
            ]);
        } else {
            return response()->json(['error' => 'Rededem Points exceeded the Promotor points'], 422);
        }
    }
}
