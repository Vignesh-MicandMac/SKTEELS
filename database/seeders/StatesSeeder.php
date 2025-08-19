<?php

namespace Database\Seeders;

use App\Models\States;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $states = [
            ['id' => 12, 'state_code' => 'KL', 'state_name' => 'Kerala'],
            ['id' => 23, 'state_code' => 'TN', 'state_name' => 'Tamil Nadu'],
        ];

        foreach ($states as $state) {
            States::updateOrCreate(['id' => $state['id']], $state);
        }
    }
}
