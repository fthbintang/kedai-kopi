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
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PendapatanReport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    use Exportable;

    protected $data;
    protected $selectedDate;

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

        $filteredDataWithNumber = $filteredData->map(function ($item, $index) {
            // Ubah instance model menjadi array
            $itemArray = $item instanceof \App\Models\PendapatanHarian ? $item->toArray() : (array) $item;
            
            // Hapus kolom 'ID' dari array jika ada
            unset($itemArray['id']); // Ubah 'id' dengan nama kolom ID sesuai kebutuhan Anda
            
            // Format nilai pendapatan menjadi mata uang Rupiah
            $formattedPendapatan = 'Rp ' . number_format($itemArray['pendapatan'], 2, ',', '.');
            
            // Masukkan kembali nilai pendapatan yang diformat ke dalam array
            $itemArray['pendapatan'] = $formattedPendapatan;
            
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
            2    => ['font' => ['bold' => true]],

            // Style the last row (Total Pendapatan) as bold text.
            count($this->data) + 3 => ['font' => ['bold' => true]], // Adjust the row number accordingly

            // Center align all cells within the specified range (A1:Dx)
            'A1:D' . (count($this->data) + 2) => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet;
        
                // Menambahkan judul di atas tabel
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'Data Laporan Pendapatan');
        
                // Format judul (teks tebal dan rata tengah)
                $sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
            AfterSheet::class => function (AfterSheet $event) {
                // Membuat isi kolom menjadi rata tengah
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A2:D' . $highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            }
        ];
    }
}