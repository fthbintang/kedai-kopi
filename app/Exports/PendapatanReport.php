<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class PendapatanReport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Menghapus kolom 'created_at' dan 'updated_at' dari setiap item
        $filteredData = $this->data->map(function ($item) {
            unset($item['created_at']);
            unset($item['updated_at']);
            return $item;
        });

        // Menambahkan nomor urut pada setiap item dalam koleksi
        $filteredDataWithNumber = $filteredData->map(function ($item, $index) {
            // Ubah instance model menjadi array
            $itemArray = $item instanceof \App\Models\PendapatanHarian ? $item->toArray() : (array) $item;
            
            // Hapus kolom 'ID' dari array jika ada
            unset($itemArray['id']); // Ubah 'id' dengan nama kolom ID sesuai kebutuhan Anda
            
            return array_merge(['No' => $index + 1], $itemArray);
        });

        // Menghitung total pendapatan
        $totalPendapatan = $filteredData->sum('pendapatan');

        // Menambahkan total pendapatan ke dalam koleksi
        $collectionWithTotal = $filteredDataWithNumber->push([
            'No' => '',
            'Tanggal' => 'Total Pendapatan: ',
            'Pendapatan' => '',
            'Keterangan' => $totalPendapatan,
        ]);

        return $collectionWithTotal;
    }
    
    public function headings(): array
    {
        return [
            ['No', 'Tanggal', 'Pendapatan', 'Keterangan']
        ];
    }
}