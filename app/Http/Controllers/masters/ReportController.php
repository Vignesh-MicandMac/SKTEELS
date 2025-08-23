<?php

namespace App\Http\Controllers\masters;

use App\Exports\RedeemGiftsExport;
use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\DealersStock;
use App\Models\Executive;
use App\Models\Promotor;
use App\Models\PromotorRedeemedGifts;
use App\Models\PromotorRedeemProduct;
use App\Models\PromotorSaleEntry;
use App\Models\SiteEntry;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function influencer_list(Request $request)
    {
        $query = Promotor::with(['dealer', 'executive', 'promotor_type', 'state', 'district', 'mappedDealers']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        $promotors = $query->get();

        return view('reports.influencer_list', compact('promotors'));
    }

    public function sale_entry_list(Request $request)
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
        return view('reports.sale_entry_list', compact('dealers', 'promotors', 'promotor_sale_entries'));
    }

    public function redeem_points_list(Request $request)
    {
        $query = PromotorRedeemProduct::with(['dealer', 'executive', 'promotor']);

        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
        }

        if ($request->filled('executive_id')) {
            $query->where('executive_id', $request->executive_id);
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

        $redeem_products = $query->orderBy('id', 'desc')->get();
        $dealers = Dealers::whereNull('deleted_at')->get();
        $executives = Executive::whereNull('deleted_at')->get();
        $promotors = Promotor::whereNull('deleted_at')->get();

        return view('reports.redeem_points_list ', compact('redeem_products', 'promotors', 'dealers', 'executives'));
    }

    public function redeem_gifts_list(Request $request)
    {
        $query = PromotorRedeemedGifts::with(['dealer', 'executive', 'promotor']);

        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
        }

        if ($request->filled('executive_id')) {
            $query->where('executive_id', $request->executive_id);
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

        $redeem_gifts = $query->orderBy('id', 'desc')->get();
        $dealers = Dealers::whereNull('deleted_at')->get();
        $executives = Executive::whereNull('deleted_at')->get();
        $promotors = Promotor::whereNull('deleted_at')->get();

        return view('reports.redeem_gifts_list ', compact('redeem_gifts', 'promotors', 'dealers', 'executives'));
    }

    public function exportRedeemGiftss(Request $request)
    {
        return Excel::download(new RedeemGiftsExport($request), 'redeem_gifts.xlsx');
    }

    public function dealer_stock_list(Request $request)
    {
        $query = DealersStock::with(['dealer']);

        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
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

        $dealer_stocks = $query->orderBy('id', 'desc')->get();
        $dealers = Dealers::whereNull('deleted_at')->get();

        return view('reports.dealer_stock_list ', compact('dealer_stocks', 'dealers'));
    }

    public function sites_list(Request $request)
    {
        $query = SiteEntry::with(['dealer', 'executive', 'promotor', 'promotorType', 'state', 'district', 'pincode']);

        if ($request->filled('dealer_id')) {
            $query->where('dealer_id', $request->dealer_id);
        }

        if ($request->filled('executive_id')) {
            $query->where('executive_id', $request->executive_id);
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

        $sites_list = $query->orderBy('id', 'desc')->get();
        $dealers = Dealers::whereNull('deleted_at')->get();
        $executives = Executive::whereNull('deleted_at')->get();
        $promotors = Promotor::whereNull('deleted_at')->get();

        return view('reports.site_list ', compact('sites_list', 'promotors', 'dealers', 'executives'));
    }
}
