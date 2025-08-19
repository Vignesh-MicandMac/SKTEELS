<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\District;
use App\Models\Promotor;
use App\Models\PromotorDealerMapping;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function store(Request $request) {}

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
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}


    public function state()
    {
        $states = States::whereNull('deleted_at')->select('id', 'state_code', 'state_name')->get();

        if (isEmpty($states)) {
            return response()->json(['status' => false, 'message' => 'States not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'States fetched successfully',
            'states' => $states
        ]);
    }

    public function getDistricts($state_id)
    {
        $districts = District::where('state_id', $state_id)->whereNull('deleted_at')->select('id', 'state_id', 'district_name')->get();
        if (isEmpty($districts)) {
            return response()->json(['status' => false, 'message' => 'Districts not found this State Id'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Districts fetched successfully',
            'states' => $districts
        ]);
    }

    public function getMappedPromotors(Request $request)
    {
        $dealer_id = $request->dealer_id;

        if (!$dealer_id) {
            return response()->json([
                'status' => false,
                'message' => 'Dealer ID is required'
            ], 400);
        }

        $mapped_promotor_ids = PromotorDealerMapping::where('dealer_id', $request->dealer_id)->pluck('promotor_id');
        $mapped_promotors = Promotor::whereIn('id', $mapped_promotor_ids)->get();

        if ($mapped_promotors->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No promotors mapped to this dealer'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully',
            'mapped_promotors' => $mapped_promotors
        ], 200);
    }
}
