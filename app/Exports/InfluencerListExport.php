<?php

namespace App\Exports;

use App\Models\Promotor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InfluencerListExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Promotor::with(['dealer', 'executive', 'promotor_type', 'state', 'district', 'mappedDealers']);

        if ($this->request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $this->request->end_date);
        }

        if ($this->request->filled('approval_status')) {
            $query->where('approval_status', $this->request->approval_status);
        }

        return $query->get();
    }

    /**
     * Map each row of data
     */
    public function map($promotor): array
    {
        return [
            $promotor->enroll_no,
            $promotor->executive->name ?? 'N/A',
            $promotor->name,
            $promotor->img_path ? asset('storage/' . $promotor->img_path) : 'N/A',
            $promotor->promotor_type->promotor_type ?? 'N/A',
            $promotor->mobile,
            $promotor->whatsapp_no,
            $promotor->aadhaar_no,
            $promotor->aadhar_front_img ? asset('storage/' . $promotor->aadhar_front_img) : 'N/A',
            $promotor->aadhar_back_img ? asset('storage/' . $promotor->aadhar_back_img) : 'N/A',
            $promotor->pan_card_no,
            $promotor->pan_front_img ? asset('storage/' . $promotor->pan_front_img) : 'N/A',
            $promotor->pan_back_img ? asset('storage/' . $promotor->pan_back_img) : 'N/A',
            $promotor->address,
            $promotor->state->name ?? 'N/A',
            $promotor->district->name ?? 'N/A',
            $promotor->area_name,
            $promotor->pincode,
            $promotor->dob,
            $promotor->approval_status == 1 ? 'Approved' : 'UnApproved',
            $promotor->points,
            $promotor->declined_reason,
        ];
    }

    /**
     * Define Excel headings
     */
    public function headings(): array
    {
        return [
            'Enroll No',
            'Executive',
            'Name',
            'Image Path',
            'Promotor Type',
            'Mobile',
            'Whatsapp No',
            'Aadhaar No',
            'Aadhar Front Img',
            'Aadhar Back Img',
            'PAN Card No',
            'PAN Front Img',
            'PAN Back Img',
            'Address',
            'State',
            'District',
            'Area Name',
            'Pincode',
            'DOB',
            'Approval Status',
            'Points',
            'Declined Reason',
        ];
    }
}
