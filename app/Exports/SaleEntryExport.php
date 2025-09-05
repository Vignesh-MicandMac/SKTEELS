<?php

namespace App\Exports;

use App\Models\PromotorSaleEntry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SaleEntryExport implements FromCollection, WithHeadings, WithMapping
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
        $query = PromotorSaleEntry::with(['dealer', 'executive', 'promotor']);

        if ($this->request->filled('dealer_id')) {
            $query->where('dealer_id', $this->request->dealer_id);
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
    public function map($saleEntry): array
    {
        $statusLabels = [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Unapproved',
        ];

        $approvedStatus = $statusLabels[$saleEntry->approved_status] ?? 'Unknown';
        $soApprovedStatus = $statusLabels[$saleEntry->so_approved_status] ?? 'Unknown';

        return [
            $saleEntry->promotor->name ?? 'N/A',
            $saleEntry->dealer->name ?? 'N/A',
            $saleEntry->executive->name ?? 'N/A',
            $saleEntry->quantity,
            $approvedStatus,
            $saleEntry->obtained_points,
            $soApprovedStatus,
            $saleEntry->so_declined_reason,
            $saleEntry->created_at ? $saleEntry->created_at->format('Y-m-d') : 'N/A',
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
            'Quantity',
            'Approved Status',
            'Obtained Points',
            'SO Approved Status',
            'SO Declined Reason',
            'Created At',
        ];
    }
}
