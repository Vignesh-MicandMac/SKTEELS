<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::whereNull('deleted_at')->get();
        return view('masters.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masters.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products,product_code',
            'description'  => 'nullable|string',
            'points'       => 'required|numeric',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'img_path.required' => 'Please upload the product image',
            'img_path.image' => 'The file must be an image.',
            'img_path.mimes' => 'Only jpeg, png, jpg, and gif images are allowed.',
            'img_path.max' => 'Image size must not exceed 2MB.',
            'product_code.unique' => 'Product Code should be unique.',
        ]);

        if ($request->hasFile('img_path')) {
            $imagePath = $request->file('img_path')->store('uploads', 'public');
            $validated['img_path'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('masters.products.index')->with('success', 'Product added successfully.');
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
        $product = Product::findOrFail($id);
        return view('masters.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $product->id,
            'description'  => 'nullable|string',
            'points'       => 'required|numeric',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'img_path.required' => 'Please upload the product image',
            'img_path.image' => 'The file must be an image.',
            'img_path.mimes' => 'Only jpeg, png, jpg, and gif images are allowed.',
            'img_path.max' => 'Image size must not exceed 2MB.',
            'product_code.unique' => 'Product Code should be unique.',
        ]);

        $validated['availability'] = $request->has('availability') ? 1 : 0;
        if ($request->hasFile('img_path')) {
            if ($product->img_path && Storage::disk('public')->exists($product->img_path)) {
                Storage::disk('public')->delete($product->img_path);
            }
            $imagePath = $request->file('img_path')->store('uploads', 'public');
            $validated['img_path'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('masters.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('masters.products.index')->with('success', 'Product Deleted successfully!');
    }

    public function updateAvailability(Request $request, Product $product)
    {
        $request->validate([
            'availability' => 'required|in:0,1',
        ]);

        $product->availability = $request->availability;
        $product->save();

        return response()->json(['success' => true]);
    }
}
