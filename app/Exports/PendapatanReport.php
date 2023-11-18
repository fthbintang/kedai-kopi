<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class PendapatanReport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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
            'Pendapatan' => 'Rp ' . number_format($totalPendapatan, 2, ',', '.'),
            'Keterangan' => '',
        ]);

        return $collectionWithTotal;
    }

    
    public function headings(): array
    {
        return [
            ['No', 'Tanggal', 'Pendapatan', 'Keterangan']
        ];
    }

    // Ini styling baris
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Style the last row (Total Pendapatan) as bold text.
            count($this->data) + 2 => ['font' => ['bold' => true]], // Adjust the row number accordingly

            // Center align all cells within the specified range (A1:Dx)
            'A1:D' . (count($this->data) + 2) => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}