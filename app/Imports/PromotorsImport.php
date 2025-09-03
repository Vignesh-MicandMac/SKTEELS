<?php

namespace App\Imports;

use App\Models\Dealers;
use App\Models\District;
use App\Models\Executive;
use App\Models\Pincode;
use App\Models\Promotor;
use App\Models\PromotorDealerMapping;
use App\Models\PromotorType;
use App\Models\States;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PromotorsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row = collect($row)->mapWithKeys(function ($value, $key) {
            return [strtolower(trim($key)) => $value];
        })->toArray();


        if (Promotor::where('mobile', $row['mobile'])->exists()) {
            return null;
        }

        $dob = null;
        if (!empty($row['dob'])) {
            if (is_numeric($row['dob'])) {

                $dob = Date::excelToDateTimeObject($row['dob'])->format('Y-m-d');
            } else {

                $dob = \Carbon\Carbon::createFromFormat('d-m-Y', trim($row['dob']))->format('Y-m-d');
            }
        }


        $promotorTypeId = PromotorType::whereRaw('LOWER(promotor_type) = ?', [strtolower(trim($row['promotortype']))])
            ->value('id');

        $stateId = States::whereRaw('LOWER(state_name) = ?', [strtolower(trim($row['state']))])->value('id');
        $districtId = District::whereRaw('LOWER(district_name) = ?', [strtolower(trim($row['district']))])->value('id');
        $pincodeId = Pincode::where('pincode', trim($row['pincode']))->value('id');

        $executive_unique_id = trim($row['executiveid']);
        $executive = Executive::where('unique_executive_id', $executive_unique_id)->first();

        $promotor = new Promotor([
            'name'            => $row['name'],
            'executive_id'    => $executive->id ?? NULL,
            'mobile'          => $row['mobile'],
            'whatsapp_no'     => $row['whatsappno'],
            'aadhaar_no'      => $row['aadhaarno'],
            'pan_card_no'     => $row['pancardno'],
            'address'         => $row['address'],
            'state_id'        => $stateId,
            'district_id'     => $districtId,
            'pincode'      => $pincodeId,
            'area_name'       => $row['area'],
            'dob'             =>  $dob,
            'promotor_type_id' => $promotorTypeId,
            'approval_status' => '1',
        ]);

        $promotor->save();

        $enrollNumber = 'PR' . str_pad($promotor->id + 100000, 6, '0', STR_PAD_LEFT);
        $promotor->enroll_no = $enrollNumber;
        $promotor->save();

        if (!empty($row['dealerid'])) {
            $dealerCodes = explode(',', $row['dealerid']);
            foreach ($dealerCodes as $dealerCode) {
                $dealerCode = trim($dealerCode);
                $dealer = Dealers::where('tally_dealer_id', $dealerCode)->first();
                if ($dealer) {
                    PromotorDealerMapping::create([
                        'promotor_id' => $promotor->id,
                        'dealer_id'   => $dealer->id,
                    ]);
                }
            }
        }

        return $promotor;
    }

    // Validation rules for each row
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'mobile'         => [
                'required',
                'digits:10',
                'unique:dealers,mobile',
                'unique:executives,mobile',
                'unique:promotors,mobile',
            ],
            'state'          => 'required|string',
            'district'       => 'required|string',
            'pincode'        => 'nullable|digits:6',
            'promotortype'  => 'required|string|exists:promotor_types,promotor_type',
            'dealerid'         => 'required|string|exists:dealers,tally_dealer_id',
            'executiveid'      => 'nullable|string|exists:executives,unique_executive_id',
        ];
    }
}
