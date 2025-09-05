<?php

namespace App\Exports;

use App\Models\SiteEntry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiteEntryExport implements FromCollection, WithHeadings, WithMapping
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
        $query = SiteEntry::with(['dealer', 'executive', 'promotor', 'promotorType', 'state', 'district', 'pincode']);

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

        return $query->get();
    }

    /**
     * Map each row for Excel
     */
    public function map($site): array
    {
        return [
            $site->promotorType->promotor_type ?? 'N/A',
            $site->site_id,
            $site->site_name,
            $site->executive->name ?? 'N/A',
            $site->dealer->name ?? 'N/A',
            $site->promotor->name ?? 'N/A',
            $site->brand_id,
            $site->visit_date ? date('Y-m-d', strtotime($site->visit_date)) : 'N/A',
            $site->img ? asset('storage/' . $site->img) : 'N/A',
            $site->lat,
            $site->long,
            $site->pincode->pincode ?? 'N/A',
            $site->state->name ?? 'N/A',
            $site->district->name ?? 'N/A',
            $site->area,
            $site->door_no,
            $site->street_name,
            $site->building_stage,
            $site->floor_stage,
            $site->contact_no,
            $site->contact_person,
            $site->requirement_qty,
            $site->created_at ? $site->created_at->format('Y-m-d') : 'N/A',
        ];
    }

    /**
     * Define Excel headings
     */
    public function headings(): array
    {
        return [
            'Promotor Type',
            'Site ID',
            'Site Name',
            'Executive',
            'Dealer',
            'Promotor',
            'Brand ID',
            'Visit Date',
            'Image',
            'Latitude',
            'Longitude',
            'Pincode',
            'State',
            'District',
            'Area',
            'Door No',
            'Street Name',
            'Building Stage',
            'Floor Stage',
            'Contact No',
            'Contact Person',
            'Requirement Qty',
            'Created At',
        ];
    }
}
