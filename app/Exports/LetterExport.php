<?php

namespace App\Exports;

use App\Models\Letter_type;
use App\Models\Letter;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class LetterExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Kode Surat',
            'Klasifikasi Surat',
            'Surat Tertaut'
        ];
    } 

    public function collection()
    {
        return Letter_type::all();
    }

    public function map($item): array {
        return [
            $item->letter_code,
            $item->name_type,
            Letter::where('letter_type_id', $item->id)->count()
        ];
    }
}
