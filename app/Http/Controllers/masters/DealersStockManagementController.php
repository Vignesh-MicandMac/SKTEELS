<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\DealersStock;
use App\Models\Promotor;
use App\Models\PromotorRedeemProduct;
use App\Models\PromotorSaleEntry;
use App\Models\SiteEntry;
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
        $dealer_stocks = DealersStock::all();
        return view('activity.stocks.index', compact('dealers', 'dealer_stocks'));
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
    public function edit()
    {
        $dealers = Dealers::whereNull('deleted_at')->get();
        $dealer_stocks = DealersStock::all();
        return view('activity.stocks.edit', compact('dealers', 'dealer_stocks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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

        $latestStock = DealersStock::where('dealer_id', $request->dealer_id)->orderBy('id', 'desc')->first();
        $previous_total_current_stock = $latestStock->total_current_stock;

        $latestStock->update([
            'total_current_stock' => $request->dispatch,
            'updated_stock' => $request->dispatch,
            'previous_total_current_stock' => $previous_total_current_stock,
        ]);
        return redirect()->route('activity.stocks.edit')->with('success', 'Stock updated for successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}

    public function closing_stock_index()
    {
        $dealers = Dealers::whereNull('deleted_at')->get();
        $dealer_stocks = DealersStock::all();
        return view('activity.stocks.closing_stock_update', compact('dealers', 'dealer_stocks'));
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

        // if ($dealer_stock->closing_stock_updated_at->toDateString() === now()->toDateString()) {
        //     return redirect()->back()->with('warning', 'You have already updated the stock today.');
        // }

        if ($dealer_stock->closing_stock_updated_at && $dealer_stock->closing_stock_updated_at->toDateString() === now()->toDateString()) {
            return redirect()->back()->with('warning', 'You have already updated the stock today.');
        }

        if ($request->stock > $dealer_stock->total_current_stock) {
            return redirect()->back()->with('warning', 'Requested stock exceeds available stock.');
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
        $promotor_ids = $promotor_sale_entries->pluck('promotor_id');
        $promotor_site_details = SiteEntry::with([
            'promotor',
            'executive',
            'dealer',
            'state',
            'district',
            'pincode',
            'promotorType'
        ])
            ->whereIn('promotor_id', $promotor_ids)
            ->whereNull('deleted_at')
            ->get()
            ->groupBy('promotor_id');

        $dealers = Dealers::whereNull('deleted_at')->get();
        $promotors = Promotor::whereNull('deleted_at')->get();

        return view('activity.stocks.sale_entry_approval', compact('promotor_sale_entries', 'dealers', 'promotors', 'promotor_site_details'));
    }

    public function sale_entry_approval_or_unapproval(Request $request, $id)
    {


        if ($request->approved_status == 1) {

            $sale_entry = PromotorSaleEntry::findOrFail($id);

            //update dealer stock
            // $update_approved_stock = DealersStock::where('dealer_id', $sale_entry->dealer_id)->orderBy('id', 'desc')->first();
            // $balance_stock = $update_approved_stock->total_stock - $sale_entry->quantity;

            // if ($update_approved_stock && $update_approved_stock->total_stock >= $sale_entry->quantity) {

            $sale_entry->approved_status = $request->approved_status;
            $sale_entry->save();

            //     $update_approved_stock->update([
            //         'promoter_sales' => $sale_entry->quantity,
            //         'balance_stock' => $balance_stock,
            //         'total_current_stock' => $balance_stock,
            //     ]);

            //update promotor points
            $update_promotor_points = Promotor::where('id', $sale_entry->promotor_id)->orderBy('id', 'desc')->first();
            $total_promotor_points = ($update_promotor_points->points ?? 0) + $sale_entry->obtained_points;

            $update_promotor_points->update([
                'points' => $total_promotor_points,
            ]);
            return response()->json(['success' => 'Approved successfully!']);
            // } else {
            //     return response()->json(['error' => 'Sale quantity exceeded the total stock by ' . $balance_stock . '!'], 422);
            // }
        }

        if ($request->approved_status == 2) {

            $sale_entry = PromotorSaleEntry::findOrFail($id);
            $sale_entry->approved_status = $request->approved_status;
            $sale_entry->declined_reason = $request->declined_reason ?? NULL;
            $sale_entry->save();

            $update_declined_stock = DealersStock::where('dealer_id', $sale_entry->dealer_id)->orderBy('id', 'desc')->first();
            $total_current_stock = $update_declined_stock->total_current_stock + $sale_entry->quantity;

            $update_declined_stock->update([
                'declined_stock' => $sale_entry->quantity,
                'date_of_declined' => now(),
                'total_current_stock' => $total_current_stock,
            ]);

            //update promotor points
            $update_promotor_points = Promotor::where('id', $sale_entry->promotor_id)->first();
            $total_promotor_points = ($update_promotor_points->points ?? 0) - $sale_entry->obtained_points;

            $update_promotor_points->update([
                'points' => $total_promotor_points,
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
            'declined_reason' => $request->declined_reason ?? NULL,
        ]);
        return response()->json(['success' => 'Updated successfully!']);
    }

    public function site_entry()
    {
        $site_entries = SiteEntry::whereNull('deleted_at')->get();
        return view('activity.stocks.site_entry', compact('site_entries'));
    }

    public function redeem_approval(Request $request)
    {
        // $redeem_products = PromotorRedeemProduct::whereNull('deleted_at')->get();
        $query = PromotorRedeemProduct::with(['dealer', 'executive', 'promotor']);

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

        $redeem_products = $query->orderBy('id', 'desc')->get();
        // $dealers = Dealers::whereNull('deleted_at')->get();
        $promotors = Promotor::whereNull('deleted_at')->get();

        return view('activity.stocks.redeem_approval', compact('redeem_products', 'promotors'));
    }

    public function redeeem_approval_or_unapproval(Request $request, $id)
    {

        if ($request->approved_status == 1) {

            $gift_product = PromotorRedeemProduct::where('id', $id)->whereNull('deleted_at')->first();
            $promotor = Promotor::where('id', $gift_product->promotor_id)->whereNull('deleted_at')->first();
            // $reduce_promotor_point = $promotor->points - $gift_product->product_redeem_points;

            // if ($gift_product->product_redeem_points <= $promotor->points) {

            //     $promotor->update([
            //         'points' => $reduce_promotor_point
            //     ]);
            $gift_product->update([
                'approved_status' => $request->approved_status,
            ]);

            return response()->json(['success' => 'Redeem Approved successfully!']);
            // } else {
            //     return response()->json(['error' => 'Rededem Points exceeded the Promotor points by ' . $reduce_promotor_point . '!'], 422);
            // }
        }

        if ($request->approved_status == 2) {

            $gift_product = PromotorRedeemProduct::where('id', $id)->whereNull('deleted_at')->first();
            $promotor = Promotor::where('id', $gift_product->promotor_id)->whereNull('deleted_at')->first();
            $reduce_promotor_point = $promotor->points + $gift_product->product_redeem_points;

            $promotor->update([
                'points' => $reduce_promotor_point
            ]);

            $gift_product->update([
                'approved_status' => $request->approved_status,
                'declined_reason' => $request->declined_reason ?? NULL,
            ]);

            return response()->json(['success' => 'Redeem UnApproved successfully!']);
        } else {
            return response()->json(['error' => 'Something went Wrong'], 422);
        }
    }
}
