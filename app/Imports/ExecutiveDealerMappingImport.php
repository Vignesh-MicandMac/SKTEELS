<?php

namespace App\Imports;

use App\Models\Dealers;
use App\Models\Executive;
use App\Models\ExecutiveDealerMapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExecutiveDealerMappingImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row = collect($row)->mapWithKeys(function ($value, $key) {
            return [strtolower(trim($key)) => trim($value)];
        })->toArray();

        $executive = Executive::where('unique_executive_id', $row['executiveid'])->first();

        if ($executive && !empty($row['dealerid'])) {
            $dealerCodes = explode(',', $row['dealerid']);
            foreach ($dealerCodes as $dealerCode) {
                $dealer = Dealers::where('tally_dealer_id', trim($dealerCode))->first();

                if ($dealer) {
                    ExecutiveDealerMapping::firstOrCreate([
                        'executive_id' => $executive->id,
                        'dealer_id'    => $dealer->id,
                    ]);
                }
            }
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'executiveid' => ['required', 'string', 'exists:executives,unique_executive_id'],
            'dealerid'    => ['required', 'string', 'exists:dealers,tally_dealer_id'],
        ];
    }
}
