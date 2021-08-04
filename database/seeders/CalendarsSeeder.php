<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Client;
use Illuminate\Database\Seeder;

class CalendarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            Calendar::factory()->count(random_int(1, 10))->create(['client_id' => $client->id]);
        }
    }
}
