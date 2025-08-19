<?php

namespace App\Http\Controllers;

use App\Models\Dealers;
use App\Models\Executive;
use App\Models\Product;
use App\Models\Promotor;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dealers = Dealers::whereNull('deleted_at')->count();
        $executives = Executive::whereNull('deleted_at')->count();
        $promotors = Promotor::whereNull('deleted_at')->count();
        $products = Product::whereNull('deleted_at')->count();
        return view('dashboard', compact('dealers', 'executives', 'promotors', 'products'));
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
        //
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
        //
    }
}
