<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Network;
use App\Models\Network212;

class NetworksSeeder extends Seeder
{
    public function run()
    {
       /* // Redes generales (215, 52, 53, 57)
        $networks = ['215', '52', '53', '57'];
        foreach ($networks as $network) {
            for ($i = 10; $i <= 15; $i++) {
                Network::create([
                    'IP' => "10.82.{$network}.{$i}",
                    'STATUS' => 'FREE',
                    'INNO' => '',
                    'PROJECT' => '',
                    'AREA' => '',
                    'PROCESS' => '',
                    'TYPE' => '',
                    'PERSON_IN_CHARGE' => ''
                ]);
            }
        }

        // Red 212
        for ($i = 10; $i <= 15; $i++) {
            Network212::create([
                'NO_EMPLOYEE' => '',
                'NAME' => '',
                'IP' => "10.82.212.{$i}",
                'STATUS' => 'FREE',
                'INNO' => '',
                'PROJECT' => '',
                'AREA' => '',
                'PROCESS' => '',
                'TYPE' => '',
                'PERSON_IN_CHARGE' => ''
            ]);
        }*/
    }
}
