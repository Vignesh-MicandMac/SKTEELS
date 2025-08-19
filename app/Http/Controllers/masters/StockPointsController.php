<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\StocksPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockPointsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stock_details = StocksPoint::whereNull('deleted_at')->get();
        return view('activity.stock_points.index', compact('stock_details'));
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
            'kg' => 'required|numeric',
            'points'  => 'required|numeric',
        ], [
            'kg.numeric' => 'Kg should be in numeric',
            'points.numeric' => 'Points should be in numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        StocksPoint::create($request->only('kg', 'points'));
        return redirect()->route('activity.points.index')->with('success', 'Created successfully.');
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
        $stock_details = StocksPoint::findOrFail($id);
        return view('activity.stock_points.edit', compact('stock_details'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'kg' => 'required|numeric',
            'points'  => 'required|numeric',
        ], [
            'kg.numeric' => 'Kg should be in numeric',
            'points.numeric' => 'Points should be in numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }
        $stock_details = StocksPoint::findOrFail($id);
        $stock_details->update([
            'kg' => $request->kg,
            'points' => $request->points
        ]);
        return redirect()->route('activity.points.index')->with('success', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stocks = StocksPoint::findOrFail($id);
        $stocks->delete();
        return redirect()->route('activity.points.index')->with('success', 'Deleted successfully.');
    }
}
