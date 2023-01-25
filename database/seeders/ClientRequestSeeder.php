<?php

namespace Database\Seeders;

use App\Models\ClientRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ClientRequestSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());

        for ($i = 0; $i < 365 * 2; $i++) {
            $date = $date->subDays(1);
            for ($j = 0; $j < rand(0, 1000); $j++) {
                ClientRequest::create([
                    'ip' => '::1',
                    'method' => 'GET',
                    'path' => 'prime',
                    'created_at' => $date,
                ]);
            }
            for ($j = 0; $j < rand(0, 1000); $j++) {
                ClientRequest::create([
                    'ip' => '::1',
                    'method' => 'GET',
                    'path' => 'even',
                    'created_at' => $date,
                ]);
            }
            echo $date.PHP_EOL;
        }
        
        echo 'mock request data success!';
    }
}