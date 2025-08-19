<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\Executive;
use App\Models\ExecutiveDealerMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExecutiveDealerMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dealers = Dealers::whereNull('deleted_at')->get();
        $executives = Executive::whereNull('deleted_at')->get();
        $executive_mappings = Executive::whereHas('dealerMappings')->with(['dealerMappings.dealer'])->get();
        return view('masters.executives_mapping.index', compact('executives', 'dealers', 'executive_mappings'));
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
            'executive_id' => 'required|exists:executives,id',
            'dealer_ids' => 'required|array|min:1',
            'dealer_ids.*' => 'exists:dealers,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', 'Please Select all the fields')->withErrors($validator)->withInput();
        }

        foreach ($request->dealer_ids as $dealer_id) {
            ExecutiveDealerMapping::create([
                'executive_id' => $request->executive_id,
                'dealer_id' => $dealer_id,
            ]);
        }

        return redirect()->back()->with('success', 'Executives With Dealers mapped successfully.');
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
        $mapped_executive = ExecutiveDealerMapping::findOrFail($id);
        $mapped_executive->delete();
        return redirect()->back()->with('success', 'Deleted successfully.');
    }

    public function delete($id)
    {
        $mapping = ExecutiveDealerMapping::findOrFail($id);
        $mapping->delete();

        return back()->with('success', 'Mapping deleted successfully.');
    }
}
