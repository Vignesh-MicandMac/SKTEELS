<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\District;
use App\Models\Executive;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ExecutivesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $executives = Executive::whereNull('deleted_at')->orderBy('id', 'desc')->get();
        $states = States::where('deleted_at', null)->get();
        return view('masters.executives.index', compact('executives', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dealers = Dealers::whereNull('deleted_at')->orderBy('id', 'desc')->get();
        $states = States::where('deleted_at', null)->get();
        $districts = District::where('deleted_at', null)->get();
        return view('masters.executives.create', compact('states', 'districts', 'dealers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:executives,mobile',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Warning', 'Please fill the required fields')->withErrors($validator)->withInput();
        }

        $executive = new Executive();
        $executive->name = $request->name;
        $executive->mobile = $request->mobile;
        $executive->address = $request->address;
        $executive->app_password = Hash::make($request->password);
        $executive->state_id = $request->state_id;
        $executive->district_id = $request->district_id;
        $executive->save();

        return redirect()->route('masters.executives.index')->with('success', 'Executive created successfully!');
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
        $executive = Executive::with('states', 'districts')->findOrFail($id);
        $states = States::where('deleted_at', null)->get();
        $districts = District::where('deleted_at', null)->get();
        return view('masters.executives.edit', compact('states', 'districts', 'executive'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('Warning', 'Please fill the required fields')->withErrors($validator)->withInput();
        }

        $executive = Executive::findOrFail($id);
        $executive->name = $request->name;
        $executive->mobile = $request->mobile;
        $executive->address = $request->address;
        $executive->app_password = Hash::make($request->password);
        $executive->state_id = $request->state_id;
        $executive->district_id = $request->district_id;
        $executive->save();

        return redirect()->route('masters.executives.index')->with('success', 'Executive updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $executive = Executive::findOrFail($id);
        $executive->delete();
        return redirect()->route('masters.executives.index')->with('success', 'Executive deleted successfully.');
    }
}
