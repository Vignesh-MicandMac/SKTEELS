<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('masters.brands.index', compact('brands'));
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
            'brand_name' => 'required|string|unique:brands|max:255',
        ], [
            'brand_name.unique' => 'Brand Name should have unique name'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        Brand::create($request->only('brand_name'));
        return redirect()->route('masters.brands.index')->with('success', 'Brand created successfully.');
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
        $brand = Brand::findOrFail($id);
        return view('masters.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|string|unique:brands|max:255',
        ], [
            'brand_name.unique' => 'Brand Name should have Unique'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', 'Please fill the required fields')->withErrors($validator)->withInput();
        }

        $brand = Brand::findOrFail($id);
        $brand->update([
            'brand_name' => $request->brand_name,
        ]);

        return redirect()->route('masters.brands.index')->with('success', 'Brand Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->forceDelete();
        return redirect()->route('masters.brands.index')->with('success', 'Promotor Type deleted successfully.');
    }
}
