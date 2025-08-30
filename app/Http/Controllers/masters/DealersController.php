<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Imports\DealersImport;
use App\Models\Dealers;
use App\Models\District;
use App\Models\Pincode;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DealersController extends Controller
{
    public function index()
    {
        $dealers = Dealers::with(['states', 'districts'])->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        return view('masters.dealers.index', compact('dealers'));
    }
    public function create()
    {
        $states = States::where('deleted_at', null)->get();
        $districts = District::where('deleted_at', null)->get();
        return view('masters.dealers.create', compact('states', 'districts'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'mobile' => 'required|digits:10|unique:dealers,mobile',
            'address' => 'string|max:200',
            'password' => 'required|min:6|confirmed',
            'state' => 'required|exists:states,id',
            'district' => 'required|exists:districts,id',
            'area' => 'required|string|max:200',
            'pincode' => 'required|digits:6',
            'gst_no' => 'nullable|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', 'Please fill the required fields')->withErrors($validator)->withInput();
        }

        $lastDealer = Dealers::orderBy('tally_dealer_id', 'desc')->first();

        $nextNumber = ($lastDealer->tally_dealer_id != NULL) ? ($lastDealer->tally_dealer_id + 1) : 1000;

        Dealers::create([
            'tally_dealer_id' => $nextNumber,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'state' => $request->state,
            'district' => $request->district,
            'area' => $request->area,
            'pincode' => $request->pincode,
            'gst_no' => $request->gst_no,
            'role' => '0',
            'action' => '1',
            'created_at' => now(),
        ]);

        return redirect()->route('masters.dealers.index')->with('success', 'Dealer added successfully.');
    }
    public function edit($id)
    {
        $dealer = Dealers::with('states', 'districts')->findOrFail($id);
        $states = States::whereNull('deleted_at')->get();
        $districts = District::where('state_id', $dealer->state)->whereNull('deleted_at')->get();

        return view('masters.dealers.edit', compact('dealer', 'states', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'address' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
            'state' => 'required|integer',
            'district' => 'required|integer',
            'area' => 'required|string',
            'pincode' => 'required|digits:6',
            'gst_no' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', 'Please fill the required fields')->withErrors($validator)->withInput();
        }

        $dealer = Dealers::findOrFail($id);
        $dealer->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'state' => $request->state,
            'district' => $request->district,
            'area' => $request->area,
            'pincode' => $request->pincode,
            'gst_no' => $request->gst_no,
        ]);

        return redirect()->route('masters.dealers.index')->with('success', 'Dealer updated successfully');
    }


    public function destroy($id)
    {
        $dealer = Dealers::findOrFail($id);
        $dealer->delete();
        return redirect()->route('masters.dealers.index')->with('success', 'Dealer deleted successfully.');
    }
    public function getDistricts($state_id)
    {
        $districts = District::where('state_id', $state_id)->whereNull('deleted_at')->get();
        return response()->json($districts);
    }
    public function getPincodes($district_id)
    {
        $pincodes = Pincode::where('district_id', $district_id)->get();
        return response()->json($pincodes);
    }

    public function bulkUpload(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:2048'
    ]);

    try {
        Excel::import(new DealersImport, $request->file('file'));
        return redirect()->route('masters.dealers.index')->with('success', 'Dealers uploaded successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
}
