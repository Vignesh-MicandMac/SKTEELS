<?php

namespace App\Exports;

use App\Models\PromotorRedeemedGifts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RedeemGiftsExport implements FromCollection, WithHeadings, WithStyles
{

    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = PromotorRedeemedGifts::with(['promotor', 'dealer', 'executive']);

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

        return $query->get()->map(function ($gift) {
            return [
                'Influencer' => $gift->promotor->name ?? 'N/A',
                'Dealer' => $gift->dealer->name ?? 'N/A',
                'Executive' => $gift->executive->name ?? 'N/A',
                'Product Image' => $gift->product_img ? asset('storage/' . $gift->product_img) : 'N/A',
                'Created At' => $gift->created_at->format('Y-m-d'),
            ];
        });
        // return PromotorRedeemedGifts::all();
    }

    public function headings(): array
    {
        return [
            'Influencer',
            'Dealer',
            'Executive',
            'Product Image',
            'Created At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
