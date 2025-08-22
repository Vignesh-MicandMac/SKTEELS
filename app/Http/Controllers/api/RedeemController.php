<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotor;
use App\Models\PromotorRedeemedGifts;
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
                'message' => 'Sites Not found for this Promotor Id',
                'data' => $promotor_sites,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Promotor Sites Fetched successfully',
            'data' => $promotor_sites,
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
}
