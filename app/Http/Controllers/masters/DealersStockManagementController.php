<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\DealersStock;
use App\Models\Promotor;
use App\Models\PromotorSaleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealersStockManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dealers = Dealers::whereNull('deleted_at')->get();
        return view('activity.stocks.index', compact('dealers'));
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
            'dealer_id' => 'required|exists:dealers,id',
            'dispatch'  => 'required|numeric|min:1',
        ], [
            'dealer_id.required' => 'Please select a dealer.',
            'dispatch.required'  => 'Please enter a stock amount.',
            'dispatch.numeric'   => 'Stock must be a number.',
            'dispatch.min'       => 'Stock must be at least 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        // Check if there's already an entry for this dealer today
        $todayStock = DealersStock::where('dealer_id', $request->dealer_id)->orderBy('id', 'desc')->whereDate('dispatch_date', now()->toDateString())->first();

        if ($todayStock) {
            // Update today's stock instead of creating new
            $todayStock->open_balance = $todayStock->total_current_stock;
            $todayStock->dispatch = $request->dispatch;
            $todayStock->total_stock = $todayStock->open_balance + $todayStock->dispatch;
            $todayStock->balance_stock = $todayStock->total_stock;
            $todayStock->total_current_stock = $todayStock->balance_stock ?? $todayStock->total_stock;
            $todayStock->save();

            return redirect()->route('activity.stocks.index')->with('success', 'Stock updated for today successfully!');
        }


        $current_dealer_stock = DealersStock::where('dealer_id', $request->dealer_id)->orderBy('id', 'desc')->first();

        $add_dealer_stock = new DealersStock();
        $add_dealer_stock->dealer_id = $request->dealer_id;

        // Case 1: No stock exists for dealer yet
        if ($current_dealer_stock === null) {
            $add_dealer_stock->open_balance = 0;
        }
        // Case 2: Stock exists — carry forward current stock
        else {
            $add_dealer_stock->open_balance = $current_dealer_stock->total_current_stock ?? 0;
        }

        $add_dealer_stock->dispatch = $request->dispatch;
        $add_dealer_stock->total_stock = $add_dealer_stock->open_balance + $add_dealer_stock->dispatch;
        $add_dealer_stock->dispatch_date = now();
        $add_dealer_stock->promoter_sales = NULL;
        $add_dealer_stock->balance_stock = $add_dealer_stock->total_stock ?? NULL;
        $add_dealer_stock->closing_stock = NULL;
        $add_dealer_stock->other_sales = NULL;
        $add_dealer_stock->declined_stock = NULL;
        $add_dealer_stock->date_of_declined = NULL;
        $add_dealer_stock->total_current_stock = isset($add_dealer_stock->balance_stock) ? $add_dealer_stock->total_stock : $current_dealer_stock->total_current_stock;
        $add_dealer_stock->save();

        return redirect()->route('activity.stocks.index')->with('success', 'Stock Added successfully!');
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
    public function destroy(string $id) {}

    public function closing_stock_index()
    {
        $dealers = Dealers::whereNull('deleted_at')->get();
        return view('activity.stocks.closing_stock_update', compact('dealers'));
    }

    public function closing_stock_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dealer_id' => 'required|exists:dealers,id',
            'stock'  => 'required|numeric|min:1',
        ], [
            'dealer_id.required' => 'Please select a dealer.',
            'stock.required'  => 'Please enter a stock amount.',
            'stock.numeric'   => 'Stock must be a number.',
            'stock.min'       => 'Stock must be at least 1.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('warning', $validator->errors()->first())->withErrors($validator)->withInput();
        }

        $dealer_stock = DealersStock::where('dealer_id', $request->dealer_id)->orderBy('id', 'desc')->first();

        if ($dealer_stock->total_current_stock <= 0) {
            return redirect()->back()->with('warning', 'Stock is 0. Cannot update.');
        }

        if ($dealer_stock->closing_stock_updated_at->toDateString() === now()->toDateString()) {
            return redirect()->back()->with('warning', 'You have already updated the stock today.');
        }


        $closing_stock =  $dealer_stock->total_current_stock - $request->stock;

        $dealer_stock->update([
            'closing_stock' => $request->stock,
            'other_sales' => $closing_stock,
            'total_current_stock' => $request->stock,
            'closing_stock_updated_at' => now()
        ]);

        return redirect()->route('activity.stocks.closing_stock_index')->with('success', 'Stock Updated successfully!');
    }

    public function getDealerStock($id)
    {
        $dealer = Dealers::findOrFail($id);

        $latestStock = DealersStock::where('dealer_id', $id)->orderBy('id', 'desc')->first();

        return response()->json([
            'name' => $dealer->name,
            'stock' => $latestStock ? $latestStock->total_current_stock : 0
        ]);
    }


    public function sale_entry(Request $request)
    {

        $query = PromotorSaleEntry::with(['dealer', 'executive', 'promotor']);

        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
        }

        if ($request->filled('promotor_id')) {
            $query->where('promotor_id', $request->promotor_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('approved_status')) {
            $query->where('approved_status', $request->approved_status);
        }

        $promotor_sale_entries = $query->orderBy('id', 'desc')->get();
        $dealers = Dealers::whereNull('deleted_at')->get();
        $promotors = Promotor::whereNull('deleted_at')->get();

        return view('activity.stocks.sale_entry_approval', compact('promotor_sale_entries', 'dealers', 'promotors'));
    }

    public function sale_entry_update(Request $request, $id)
    {

        $sale_entry = PromotorSaleEntry::findOrFail($id);
        $sale_entry->approved_status = $request->approved_status;
        $sale_entry->save();

        if ($request->approved_status == 2) {

            $update_declined_stock = DealersStock::where('dealer_id', $sale_entry->dealer_id)->orderBy('id', 'desc')->first();
            $total_current_stock = $update_declined_stock->total_current_stock + $sale_entry->quantity;
            $update_declined_stock->update([
                'declined_stock' => $sale_entry->quantity,
                'date_of_declined' => now(),
                'total_current_stock' => $total_current_stock,
            ]);

            return response()->json(['success' => 'UnApproved successfully!']);
        }
    }

    public function promotors_approval_list(Request $request)
    {
        $promotors = Promotor::whereNull('deleted_at')->get();
        return view('activity.promotors_approval', compact('promotors'));
    }

    public function promotors_approval_update(Request $request, $id)
    {
        $promotors = Promotor::findOrFail($id);
        $promotors->update([    
            'approval_status' => $request->approved_status,
        ]);
        return response()->json(['success' => 'Updated successfully!']);
    }
}
