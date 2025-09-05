<?php

namespace App\Exports;

use App\Models\PromotorRedeemProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PromotorRedeemProductExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get collection with filters
     */
    public function collection()
    {
        $query = PromotorRedeemProduct::with(['dealer', 'executive', 'promotor']);

        if ($this->request->filled('dealer_id')) {
            $query->where('dealer_id', $this->request->dealer_id);
        }

        if ($this->request->filled('executive_id')) {
            $query->where('executive_id', $this->request->executive_id);
        }

        if ($this->request->filled('promotor_id')) {
            $query->where('promotor_id', $this->request->promotor_id);
        }

        if ($this->request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $this->request->end_date);
        }

        if ($this->request->filled('approved_status')) {
            $query->where('approved_status', $this->request->approved_status);
        }

        return $query->get();
    }

    /**
     * Map each row for Excel
     */
    public function map($redeem): array
    {
        // Status Labels
        $statusLabels = [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Unapproved',
        ];

        $approvedStatus = $statusLabels[$redeem->approved_status] ?? 'Unknown';
        $soApprovedStatus = $statusLabels[$redeem->so_approved_status] ?? 'Unknown';

        return [
            $redeem->promotor->name ?? 'N/A',
            $redeem->dealer->name ?? 'N/A',
            $redeem->executive->name ?? 'N/A',
            $redeem->product_id,
            $redeem->product_code,
            $redeem->product_name,
            $redeem->redeemed_date ? date('Y-m-d', strtotime($redeem->redeemed_date)) : 'N/A',
            $redeem->promotor_points,
            $redeem->product_redeem_points,
            $redeem->balance_promotor_points,
            $approvedStatus,
            $redeem->declined_reason,
            $soApprovedStatus,
            $redeem->so_declined_reason,
            $redeem->created_at ? $redeem->created_at->format('Y-m-d') : 'N/A',
        ];
    }

    /**
     * Define Excel headings
     */
    public function headings(): array
    {
        return [
            'Promotor',
            'Dealer',
            'Executive',
            'Product ID',
            'Product Code',
            'Product Name',
            'Redeemed Date',
            'Promotor Points',
            'Product Redeem Points',
            'Balance Promotor Points',
            'Approved Status',
            'Declined Reason',
            'SO Approved Status',
            'SO Declined Reason',
            'Created At',
        ];
    }
}
