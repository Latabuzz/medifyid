<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    private int $no = 0;

    public function collection()
    {
        return MasterItem::with('kategoriItems')->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama kategori',
            'Nama items',
            'Nama supplier',
            'Harga',
            'Laba',
            'Hargajual',
        ];
    }

    public function map($item): array
    {
        $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

        return [
            ++$this->no,
            $item->kategoriItems->pluck('nama')->join(', '),
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            round($hargaJual),
        ];
    }
}
