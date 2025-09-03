<?php

namespace App\Imports;

use App\Models\Dealers;
use App\Models\DealersStock;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClosingStocksImport implements ToModel, WithHeadingRow
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

        $dealer_unique_id = trim($row['dealerid']);
        $dealer = Dealers::where('tally_dealer_id', $dealer_unique_id)->first();

        if (!$dealer) {
            return null; // Skip if dealer not found
        }

        $dealer_stock = DealersStock::where('dealer_id', $dealer->id)->orderBy('id', 'desc')->first();

        if (!$dealer_stock) {
            return null; // Skip if no stock exists
        }

        // If no stock available, skip row
        if ($dealer_stock->total_current_stock <= 0) {
            return null;
        }

        // If closing stock exceeds available stock, skip row
        if ($row['closingstock'] > $dealer_stock->total_current_stock) {
            return null;
        }

        $closing_stock = $dealer_stock->total_current_stock - $row['closingstock'];

        $dealer_stock->update([
            'closing_stock'            => $row['closingstock'],
            'other_sales'              => $closing_stock,
            'total_current_stock'      => $row['closingstock'],
            'closing_stock_updated_at' => Carbon::now(),
        ]);

        return $dealer_stock;
    }
}
