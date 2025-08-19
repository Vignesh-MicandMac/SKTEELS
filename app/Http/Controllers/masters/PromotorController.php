<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\District;
use App\Models\Promotor;
use App\Models\PromotorDealerMapping;
use App\Models\PromotorType;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PromotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = States::where('deleted_at', null)->get();
        $districts = District::where('deleted_at', null)->get();
        $promotor_types = PromotorType::where('deleted_at', null)->get();
        $dealers = Dealers::where('deleted_at', null)->get();
        $promotors = Promotor::with(['dealer', 'state', 'district', 'promotor_type', 'mappedDealers'])->get();
        return view('masters.promotors.index', compact('states', 'districts', 'promotor_types', 'dealers', 'promotors'));
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
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'mobile'            => 'required|digits:10',
            'whatsapp_no'       => 'required|digits:10',
            'aadhar_no'         => 'required|digits:12',
            'door_no'           => 'required|string|max:255',
            'state_id'          => 'required|string',
            'district_id'       => 'required|string',
            'area_name'         => 'required|string|max:255',
            'pincode'           => 'required|digits:6',
            'dob'               => 'required|date',
            'promotor_type_id'  => 'required|exists:promotor_types,id',
            'img_path'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dealer_id' => 'required|array',
            'dealer_id.*' => 'exists:dealers,id',
        ], [
            'mobile.digits' => 'Mobile number must be 10 digits.',
            'aadhar_no.digits' => 'Aadhar number must be 12 digits.',
            'pincode.digits' => 'Pincode must be 6 digits.',
            'img_path.max' => 'Image must be less than 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('uploads/promotors', 'public');
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
            'door_no'           => $request->door_no,
            'state_id'          => $request->state_id,
            'district_id'       => $request->district_id,
            'area_name'         => $request->area_name,
            'pincode'           => $request->pincode,
            'dob'               => $request->dob,
            'approval_status'   => '0',
            'is_active'         => 1,
        ]);

        $enrollNumber = 'SK' . str_pad($promotor->id + 100000, 6, '0', STR_PAD_LEFT);
        $promotor->enroll_no = $enrollNumber;
        $promotor->save();

        foreach ($request->dealer_id as $dealerId) {
            PromotorDealerMapping::create([
                'promotor_id' => $promotor->id,
                'dealer_id' => $dealerId,
            ]);
        }

        return redirect()->route('masters.promotors.index')->with('success', 'Promotor created successfully!');
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
        $promotor = Promotor::findOrFail($id);
        $states = States::where('deleted_at', null)->get();
        $districts = District::where('deleted_at', null)->get();
        $promotor_types = PromotorType::where('deleted_at', null)->get();
        $dealers = Dealers::where('deleted_at', null)->get();
        $selectedDealerIds = $promotor->mappedDealers->pluck('id')->toArray();
        return view('masters.promotors.edit', compact('states', 'districts', 'promotor_types', 'dealers', 'promotor', 'selectedDealerIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promotor = Promotor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'mobile'            => 'required|digits:10',
            'whatsapp_no'       => 'required|digits:10',
            'aadhar_no'         => 'required|digits:12',
            'door_no'           => 'required|string|max:255',
            'state_id'          => 'required|string',
            'district_id'       => 'required|string',
            'area_name'         => 'required|string|max:255',
            'pincode'           => 'required|digits:6',
            'dob'               => 'required|date',
            'promotor_type_id'  => 'required|exists:promotor_types,id',
            'img_path'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dealer_id' => 'required|array',
            'dealer_id.*' => 'exists:dealers,id',
        ], [
            'mobile.digits'     => 'Mobile number must be 10 digits.',
            'aadhar_no.digits'  => 'Aadhar number must be 12 digits.',
            'pincode.digits'    => 'Pincode must be 6 digits.',
            'state_id.required'      => 'State field is required.',
            'district_id.required'      => 'District field is required.',
            'promotor_type_id.required'      => 'Promotor field is required.',
            'dealer_id.required'      => 'Dealer field is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        $imagePath = $promotor->img_path;

        if ($request->hasFile('img_path')) {
            if ($promotor->img_path && Storage::disk('public')->exists($promotor->img_path)) {
                Storage::disk('public')->delete($promotor->img_path);
            }
            $imagePath = $request->file('img_path')->store('uploads/promotors', 'public');
        }

        $promotor->update([
            'executive_id'      => $request->executive_id,
            'name'              => $request->name,
            'img_path'          => $imagePath,
            'promotor_type_id'  => $request->promotor_type_id,
            'mobile'            => $request->mobile,
            'whatsapp_no'       => $request->whatsapp_no,
            'aadhaar_no'        => $request->aadhar_no,
            'door_no'           => $request->door_no,
            'state_id'          => $request->state_id,
            'district_id'       => $request->district_id,
            'area_name'         => $request->area_name,
            'pincode'           => $request->pincode,
            'dob'               => $request->dob,
            'approval_status'   => 0,
            'is_active'         => 1,
        ]);

        PromotorDealerMapping::where('promotor_id', $promotor->id)->forceDelete();

        foreach ($request->dealer_id as $dealerId) {
            PromotorDealerMapping::create([
                'promotor_id' => $promotor->id,
                'dealer_id' => $dealerId,
            ]);
        }
        return redirect()->route('masters.promotors.index')->with('success', 'Promotor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promotor = Promotor::findOrFail($id);
        if ($promotor->img_path && Storage::exists($promotor->img_path)) {
            Storage::delete($promotor->img_path);
        }
        $promotor->delete();
        PromotorDealerMapping::where('promotor_id', $id)->delete();
        return redirect()->route('masters.promotors.index')->with('success', 'Promotor Deleted successfully!');
    }

    public function mapping_dealers(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'enroll_no' => 'required|exists:promotors,enroll_no',
            'dealer_id' => 'required|array',
            'dealer_id.*' => 'exists:dealers,id',
        ], [
            'dealer_id,required' => 'Dealer field is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        $promotor = Promotor::where('enroll_no', $request->enroll_no)->first();

        PromotorDealerMapping::where('promotor_id', $promotor->id)->forceDelete();

        foreach ($request->dealer_id as $dealerId) {
            PromotorDealerMapping::create([
                'promotor_id' => $promotor->id,
                'dealer_id' => $dealerId,
            ]);
        }

        return redirect()->route('masters.promotors.index')->with('success', 'Dealers assigned successfully!');
    }
}
