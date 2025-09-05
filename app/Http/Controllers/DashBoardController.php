<?php

namespace App\Http\Controllers;

use App\Models\Dealers;
use App\Models\DealersStock;
use App\Models\Executive;
use App\Models\Product;
use App\Models\Promotor;
use App\Models\PromotorRedeemedGifts;
use App\Models\PromotorRedeemProduct;
use App\Models\PromotorSaleEntry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $users = User::whereNull('deleted_at')->count();
        $redeems = PromotorRedeemProduct::where('approved_status', 1)->whereNull('deleted_at')->count();

        // Dealer stock data
        $dealerStocks = DealersStock::select(
            'dealer_id',
            DB::raw('SUM(total_current_stock) as total_stock'),
            DB::raw('SUM(closing_stock) as closing_stock')
        )->groupBy('dealer_id')->with('dealer')->limit(20)->get();

        // Daily sales trend
        $salesTrend = DealersStock::select(
            DB::raw('DATE(dispatch_date) as date'),
            DB::raw('SUM(dispatch) as dispatch'),
            DB::raw('SUM(promoter_sales) as promoter_sales'),
            DB::raw('SUM(other_sales) as other_sales')
        )->groupBy('date')->orderBy('date', 'asc')->get();

        // Promotor points leaderboard
        $promotorschart = Promotor::select('name', 'points')->orderByDesc('points')->limit(10)->get();

        //Sale entry count based on dealer and executive 
        $dealerCount = PromotorSaleEntry::whereNotNull('dealer_id')->count();
        $executiveCount = PromotorSaleEntry::whereNotNull('executive_id')->count();

        $salesTotals = [
            'dispatch' => $salesTrend->sum('dispatch'),
            'promoter_sales' => $salesTrend->sum('promoter_sales'),
            'other_sales' => $salesTrend->sum('other_sales'),
        ];
        // Top Dealers
        $topDealers = PromotorSaleEntry::select('dealer_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('dealer_id')
            ->with('dealer')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Top Executives
        $topExecutives = PromotorSaleEntry::select('executive_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('executive_id')
            ->with('executive')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'dealers',
            'executives',
            'promotors',
            'products',
            'redeems',
            'users',
            'dealerStocks',
            'salesTrend',
            'promotorschart',
            'dealerCount',
            'executiveCount',
            'salesTotals',
            'topDealers',
            'topExecutives',
        ));
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
