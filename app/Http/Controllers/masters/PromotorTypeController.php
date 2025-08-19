<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\PromotorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotor_types = PromotorType::all();
        return view('masters.promotor_type.index', compact('promotor_types'));
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
            'promotor_type' => 'required|string|unique:promotor_types|max:255',
        ], [
            'promotor_type.unique' => 'Promotor type should have unique name'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', 'Something went wrong')->withErrors($validator)->withInput();
        }

        PromotorType::create($request->only('promotor_type'));
        return redirect()->route('masters.pro_type.index')->with('success', 'Promotor Type created successfully.');
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
        $promotor_type = PromotorType::findOrFail($id);
        return view('masters.promotor_type.edit', compact('promotor_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'promotor_type' => 'required|string|unique:promotor_types|max:255',
        ], [
            'promotor_type.unique' => 'Promotor type should have Unique'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', 'Please fill the required fields')->withErrors($validator)->withInput();
        }

        $role = PromotorType::findOrFail($id);
        $role->update([
            'promotor_type' => $request->promotor_type,
        ]);

        return redirect()->route('masters.pro_type.index')->with('success', 'Promotor Type Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promotor_type = PromotorType::findOrFail($id);
        $promotor_type->forceDelete();
        return redirect()->route('masters.pro_type.index')->with('success', 'Promotor Type deleted successfully.');
    }
}
