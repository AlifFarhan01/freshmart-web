<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;

class DataExport implements FromCollection, WithMapping, WithHeadings
{

    use Exportable;

    public function __construct(public Collection $records)
    {
        $this->records = $records;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
     public function collection()
    {   
        return $this->records;
    }

    public function map($data): array
    {
        return [
            $data->transaksi->user->name,
            $data->produk->nama,
            $data->qty,
            $data->total,
            $data->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            // '#',
            'Customer',
            'Produk',
            'QTY',
            'Total',
            'Tanggal',
        ];
    }
}
