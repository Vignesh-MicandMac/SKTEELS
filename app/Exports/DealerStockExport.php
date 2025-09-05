<?php

namespace App\Exports;

use App\Models\DealersStock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DealerStockExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get filtered collection
     */
    public function collection()
    {
        $query = DealersStock::with(['dealer']);

        if ($this->request->filled('dealer_id')) {
            $query->where('dealer_id', $this->request->dealer_id);
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
    public function map($stock): array
    {
        return [
            $stock->dealer->name ?? 'N/A',
            $stock->dispatch,
            $stock->total_stock,
            $stock->dispatch_date ? date('Y-m-d', strtotime($stock->dispatch_date)) : 'N/A',
            $stock->promoter_sales,
            $stock->balance_stock,
            $stock->closing_stock,
            $stock->other_sales,
            $stock->declined_stock,
            $stock->date_of_declined ? date('Y-m-d', strtotime($stock->date_of_declined)) : 'N/A',
            $stock->updated_stock,
            $stock->previous_total_current_stock,
            $stock->total_current_stock,
            $stock->closing_stock_updated_at ? date('Y-m-d', strtotime($stock->closing_stock_updated_at)) : 'N/A',
            $stock->created_at ? $stock->created_at->format('Y-m-d') : 'N/A',
        ];
    }

    /**
     * Define Excel headings
     */
    public function headings(): array
    {
        return [
            'Dealer',
            'Dispatch',
            'Total Stock',
            'Dispatch Date',
            'Promoter Sales',
            'Balance Stock',
            'Closing Stock',
            'Other Sales',
            'Declined Stock',
            'Date of Declined',
            'Updated Stock',
            'Previous Total Current Stock',
            'Total Current Stock',
            'Closing Stock Updated At',
            'Approved Status',
            'Created At',
        ];
    }
}
