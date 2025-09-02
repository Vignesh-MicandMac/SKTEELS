<?php

namespace App\Imports;

use App\Models\District;
use App\Models\Executive;
use App\Models\Pincode;
use App\Models\States;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExecutivesImport implements ToModel, WithHeadingRow, WithValidation
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
        $districtName = $row['password'] ?? null;
        $stateName = $row['state'] ?? null;
        $districtName = $row['district'] ?? null;

        if (!$name || !$mobile || !$stateName || !$districtName) {
            throw ValidationException::withMessages([
                'row' => 'Required fields missing: name, mobile, state, or district.'
            ]);
        }

        $stateId = States::whereRaw('LOWER(state_name) = ?', [strtolower(trim($row['state']))])->value('id');
        $districtId = District::whereRaw('LOWER(district_name) = ?', [strtolower(trim($row['district']))])->value('id');

        $lastExecutive = Executive::orderBy('unique_executive_id', 'desc')->first();

        if ($lastExecutive && $lastExecutive->unique_executive_id != null) {

            $lastNumber = (int) str_replace('EX', '', $lastExecutive->unique_executive_id);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1000;
        }

        return new Executive([
            'unique_executive_id' =>  'EX' . $nextNumber,
            'name' => $row['name'],
            'mobile' => $row['mobile'],
            'address' => $row['address'] ?? null,
            'app_password' => Hash::make($row['password'] ?? '123456'),
            'state_id' => $stateId,
            'district_id' => $districtId,
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
        ];
    }
}
