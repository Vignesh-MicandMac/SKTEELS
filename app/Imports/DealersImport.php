<?php

namespace App\Imports;

use App\Models\Dealers;
use App\Models\District;
use App\Models\Executive;
use App\Models\Pincode;
use App\Models\States;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DealersImport implements ToModel, WithHeadingRow, WithValidation
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

        $name = $row['name'] ?? null;
        $mobile = $row['mobile'] ?? null;
        $stateName = $row['state'] ?? null;
        $districtName = $row['district'] ?? null;
        $pincodeValue = $row['pincode'] ?? null;

        if (!$name || !$mobile || !$stateName || !$districtName) {
            throw ValidationException::withMessages([
                'row' => 'Required fields missing: name, mobile, state, or district.'
            ]);
        }

        $stateId = States::whereRaw('LOWER(state_name) = ?', [strtolower(trim($row['state']))])->value('id');
        $districtId = District::whereRaw('LOWER(district_name) = ?', [strtolower(trim($row['district']))])->value('id');
        $pincodeId = Pincode::where('pincode', trim($row['pincode']))->value('id');


        $lastDealer = Dealers::orderBy('tally_dealer_id', 'desc')->first();
        $nextNumber = ($lastDealer && $lastDealer->tally_dealer_id != null)
            ? ($lastDealer->tally_dealer_id + 1)
            : 1000;

        return new Dealers([
            'tally_dealer_id' => $nextNumber,
            'name' => $row['name'],
            'mobile' => $row['mobile'],
            'address' => $row['address'] ?? null,
            'password' => Hash::make($row['password'] ?? '123456'),
            'state' => $stateId,
            'district' => $districtId,
            'area' => $row['area'],
            'pincode' => $pincodeId,
            'gst_no' => $row['gst_no'] ?? null,
            'role' => '0',
            'action' => '1',
            'created_at' => now(),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'mobile'   => [
                'required',
                'digits:10',
                'unique:dealers,mobile',
                'unique:executives,mobile',
            ],
            'state'    => 'required|string',
            'district' => 'required|string',
            'area'     => 'nullable|string',
            'pincode'  => 'nullable|digits:6',
        ];
    }
}
