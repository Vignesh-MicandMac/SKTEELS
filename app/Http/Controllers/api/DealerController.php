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
use Illuminate\Support\Facades\Storage;
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

        $mapped_promotor_ids = PromotorDealerMapping::where('dealer_id', $request->dealer_id)->whereNull('deleted_at')->pluck('promotor_id');
        $mapped_promotors = Promotor::whereIn('id', $mapped_promotor_ids)->whereNull('deleted_at')->get();

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

    public function add_promotors(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'mobile'            => 'required|digits:10',
            'whatsapp_no'       => 'required|digits:10',
            'aadhar_no'         => 'required|digits:12',
            'address'           => 'required|string|max:255',
            'state_id'          => 'required|string',
            'district_id'       => 'required|string',
            'area_name'         => 'required|string|max:255',
            'pincode'           => 'required|digits:6',
            'dob'               => 'required|date',
            'promotor_type_id'  => 'required|exists:promotor_types,id',
            'img_path'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dealer_id'         => 'required|array',
            'dealer_id.*'       => 'exists:dealers,id',
        ], [
            'mobile.digits'     => 'Mobile number must be 10 digits.',
            'aadhar_no.digits'  => 'Aadhar number must be 12 digits.',
            'pincode.digits'    => 'Pincode must be 6 digits.',
            'img_path.max'      => 'Image must be less than 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $imagePath = null;

            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = public_path('storage/uploads/promotors');

                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }

                $file->move($path, $filename);

                $imagePath = 'uploads/promotors/' . $filename;
            }

            $promotor = Promotor::create([
                'dealer_id'         => $request->dealer_id,
                'executive_id'      => $request->executive_id,
                'name'              => $request->name,
                'img_path'          => $imagePath,
                'promotor_type_id'  => $request->promotor_type_id,
                'mobile'            => $request->mobile,
                'whatsapp_no'       => $request->whatsapp_no,
                'aadhaar_no'        => $request->aadhar_no,
                'address'           => $request->address,
                'state_id'          => $request->state_id,
                'district_id'       => $request->district_id,
                'area_name'         => $request->area_name,
                'pincode'           => $request->pincode,
                'dob'               => $request->dob,
                'approval_status'   => '1',
                'is_active'         => 1,
            ]);

            $enrollNumber = 'PR' . str_pad($promotor->id + 100000, 6, '0', STR_PAD_LEFT);
            $promotor->enroll_no = $enrollNumber;
            $promotor->save();

            foreach ($request->dealer_id as $dealerId) {
                PromotorDealerMapping::create([
                    'promotor_id' => $promotor->id,
                    'dealer_id'   => $dealerId,
                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Promotor created successfully!',
                'data'    => $promotor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
