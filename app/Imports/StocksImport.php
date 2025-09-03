<?php

namespace App\Imports;

use App\Models\Dealers;
use App\Models\DealersStock;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StocksImport implements ToModel, WithHeadingRow
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

        $current_dealer_stock = DealersStock::where('dealer_id', $dealer->id)->orderBy('id', 'desc')->first();

        $add_dealer_stock = new DealersStock();
        $add_dealer_stock->dealer_id = $dealer->id;

        // Case 1: No stock exists for dealer yet
        if ($current_dealer_stock === null) {
            $add_dealer_stock->open_balance = 0;
        }
        // Case 2: Stock exists — carry forward current stock
        else {
            $add_dealer_stock->open_balance = $current_dealer_stock->total_current_stock ?? 0;
        }


        $add_dealer_stock->dispatch = $row['dispatch'] ?? 0;
        $add_dealer_stock->total_stock = $add_dealer_stock->open_balance + $add_dealer_stock->dispatch;
        $add_dealer_stock->dispatch_date = !empty($row['dispatch_date']) ? Carbon::parse($row['dispatch_date']) : now();

        $add_dealer_stock->promoter_sales = null;
        $add_dealer_stock->balance_stock = $add_dealer_stock->total_stock ?? null;
        $add_dealer_stock->closing_stock = null;
        $add_dealer_stock->other_sales = null;
        $add_dealer_stock->declined_stock = null;
        $add_dealer_stock->date_of_declined = null;

        $add_dealer_stock->total_current_stock = isset($add_dealer_stock->balance_stock)
            ? $add_dealer_stock->total_stock
            : ($current_dealer_stock->total_current_stock ?? 0);

        $add_dealer_stock->save();

        return $add_dealer_stock;
    }
}
