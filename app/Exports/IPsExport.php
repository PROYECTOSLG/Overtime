<?php

namespace App\Exports;

use App\Models\Network;
use App\Models\Network212;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IPsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $networks = Network::select(
            'IP', 'STATUS', 'INNO', 'PROJECT', 'AREA', 'PROCESS', 'TYPE', 'PERSON_IN_CHARGE'
        )->get();

        $network212 = Network212::select(
            'IP', 'STATUS', 'INNO', 'PROJECT', 'AREA', 'PROCESS', 'TYPE', 'PERSON_IN_CHARGE'
        )->get();

        return $networks->merge($network212);
    }

    public function headings(): array
    {
        return [
            'IP', 'STATUS', 'INNO', 'PROJECT', 'AREA', 'PROCESS', 'TYPE', 'PERSON_IN_CHARGE'
        ];
    }
}
