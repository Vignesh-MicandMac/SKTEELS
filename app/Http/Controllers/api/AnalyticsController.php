<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Promotor;
use App\Models\PromotorDealerMapping;
use App\Models\PromotorRedeemProduct;
use App\Models\PromotorSaleEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AnalyticsController extends Controller
{

    public function getDealerMonlthySales_and_overAllSales(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'dealer_id' => 'required|integer|exists:dealers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $month = now()->month;
        $year  = now()->year;

        $totalQuantity = PromotorSaleEntry::where('approved_status', '1')
            ->where('dealer_id', $request->dealer_id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('quantity');

        $totalSaleEntry = PromotorSaleEntry::where('dealer_id', $request->dealer_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        $mapped_promotor_ids = PromotorDealerMapping::where('dealer_id', $request->dealer_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->whereNull('deleted_at')->pluck('promotor_id');
        $totalPromotors = Promotor::whereIn('id', $mapped_promotor_ids)->where('approval_status', '1')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $totalRedeems = PromotorRedeemProduct::where('dealer_id', $request->dealer_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        //OverAll sales and other data's
        $overAllQuantity = PromotorSaleEntry::where('approved_status', '1')->where('dealer_id', $request->dealer_id)->sum('quantity');
        $mapped_promotor_ids = PromotorDealerMapping::where('dealer_id', $request->dealer_id)->whereNull('deleted_at')->pluck('promotor_id');
        $overAllPromotors = Promotor::whereIn('id', $mapped_promotor_ids)->whereNull('deleted_at')->count();
        $overAllRedeems = PromotorRedeemProduct::where('dealer_id', $request->dealer_id)->count();

        $statusCounts = Promotor::whereIn('id', $mapped_promotor_ids)
            ->whereNull('deleted_at')
            ->selectRaw("
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as total_active,
                SUM(CASE WHEN is_active = 2 THEN 1 ELSE 0 END) as total_inactive,
                SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as total_idle")
            ->first();

        $total_active_promotors = (int)$statusCounts->total_active;
        $total_inactive_promotors = (int)$statusCounts->total_inactive;
        $total_idle_promotors = (int)$statusCounts->total_idle;



        return response()->json([
            'status' => true,
            'message' => 'Dealers Data Fetched Successfully',
            'dealer_id' => $request->dealer_id,
            'monthly_sales' => [
                'date_range' => now()->format('F Y'),
                'total_sales_quantity' => $totalQuantity,
                'total_sales_entries' => $totalSaleEntry,
                'total_promotors' => $totalPromotors,
                'total_redeems' => $totalRedeems,
                'total_active_promotors' => $total_active_promotors,
                'total_inactive_promotors' => $total_inactive_promotors,
                'total_idle_promotors' => $total_idle_promotors,
            ],
            'overall_sales' => [
                'overall_sales_quantity' => $overAllQuantity,
                'overall_promotors' => $overAllPromotors,
                'overall_redeems' => $overAllRedeems,
            ]
        ]);
    }

    public function promotor_status_change(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promotor_id' => 'required|integer|exists:promotors,id',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $promotorId = $request->promotor_id;
        $status = $request->status;

        $updated = Promotor::where('id', $promotorId)->whereNull('deleted_at')->update(['is_active' => $status]);

        if ($updated) {
            return response()->json([
                'status' => true,
                'message' => 'Promotor status updated successfully',
                'promotor_id' => $promotorId,
                'new_status' => $status
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Promotor not found or already deleted'
        ], 404);
    }


    public function getExecutiveMonlthySales_and_overAllSales(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'executive_id' => 'required|integer|exists:executives,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $month = now()->month;
        $year  = now()->year;

        $totalQuantity = PromotorSaleEntry::where('approved_status', '1')
            ->where('executive_id', $request->executive_id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('quantity');

        $totalSaleEntry = PromotorSaleEntry::where('executive_id', $request->executive_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        $totalPromotors = Promotor::where('executive_id', $request->executive_id)->where('approval_status', '1')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $totalRedeems = PromotorRedeemProduct::where('executive_id', $request->executive_id)->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        //OverAll sales and other data's
        $overAllQuantity = PromotorSaleEntry::where('approved_status', '1')->where('executive_id', $request->executive_id)->sum('quantity');
        $mapped_promotor_ids = Promotor::where('executive_id', $request->executive_id)->whereNull('deleted_at')->pluck('id');
        $overAllPromotors = Promotor::where('executive_id', $request->executive_id)->whereNull('deleted_at')->count();
        $overAllRedeems = PromotorRedeemProduct::where('executive_id', $request->executive_id)->count();

        $statusCounts = Promotor::whereIn('id', $mapped_promotor_ids)
            ->whereNull('deleted_at')
            ->selectRaw("
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as total_active,
                SUM(CASE WHEN is_active = 2 THEN 1 ELSE 0 END) as total_inactive,
                SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as total_idle")
            ->first();

        $total_active_promotors = (int)$statusCounts->total_active;
        $total_inactive_promotors = (int)$statusCounts->total_inactive;
        $total_idle_promotors = (int)$statusCounts->total_idle;



        return response()->json([
            'status' => true,
            'message' => 'Executive Data Fetched Successfully',
            'executive_id' => $request->executive_id,
            'monthly_sales' => [
                'date_range' => now()->format('F Y'),
                'total_sales_quantity' => $totalQuantity,
                'total_sales_entries' => $totalSaleEntry,
                'total_promotors' => $totalPromotors,
                'total_redeems' => $totalRedeems,
                'total_active_promotors' => $total_active_promotors,
                'total_inactive_promotors' => $total_inactive_promotors,
                'total_idle_promotors' => $total_idle_promotors,
            ],
            'overall_sales' => [
                'overall_sales_quantity' => $overAllQuantity,
                'overall_promotors' => $overAllPromotors,
                'overall_redeems' => $overAllRedeems,
            ]
        ]);
    }
}
