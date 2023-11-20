<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class BarangMasukReport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function collection()
    {
        $data = DB::table('list_barang_masuks')
            ->join('barang_masuks', 'list_barang_masuks.barang_masuk_id', '=', 'barang_masuks.id')
            ->join('barangs', 'list_barang_masuks.barang_id', '=', 'barangs.id')
            ->where('barang_masuks.status', 'ACC')
            ->select(
                'barang_masuks.nama_sesi',
                'barangs.nama_barang',
                'list_barang_masuks.stok_sebelum',
                'list_barang_masuks.stok_sesudah',
                'list_barang_masuks.stok_masuk',
                'barang_masuks.created_at'
            )
            ->get();

        $mappedData = $data->map(function ($item) {
            return [
                'Nama Sesi' => $item->nama_sesi,
                'Nama Barang' => $item->nama_barang,
                'Stok Sebelum' => $item->stok_sebelum,
                'Stok Masuk' => $item->stok_masuk,
                'Stok Sesudah' => $item->stok_sesudah,
                'Created At' => $item->created_at,
            ];
        });

        return $mappedData;
    }

    public function headings(): array
    {
        return [
            'Nama Sesi',
            'Nama Barang',
            'Stok Sebelum',
            'Stok Masuk',
            'Stok Sesudah',
            'Created At',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();
                $currentSesi = null;
                $mergeStart = 2;
    
                // Formatting heading (membuat teks tebal dan rata tengah)
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
    
                // Membuat isi kolom menjadi rata tengah
                $sheet->getStyle('A2:F' . $highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                // Menggabungkan kolom 'Nama Sesi' jika sama
                for ($row = 2; $row <= $highestRow; $row++) {
                    $sesi = $sheet->getCell('A' . $row)->getValue();
    
                    if ($sesi !== $currentSesi) {
                        if ($currentSesi !== null) {
                            $sheet->mergeCells("A$mergeStart:A" . ($row - 1));
                        }
    
                        $currentSesi = $sesi;
                        $mergeStart = $row;
                    }
                }
    
                // Merge untuk kasus terakhir (jika diperlukan)
                if ($mergeStart !== $highestRow) {
                    $sheet->mergeCells("A$mergeStart:A$highestRow");
                }
    
                // Contoh pengaturan lebar kolom secara manual
                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(30);
                // ... dan seterusnya untuk setiap kolom
    
                // Contoh pengaturan ukuran kertas pada saat ekspor PDF
                $sheet->getDelegate()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getDelegate()->getPageSetup()->setFitToWidth(1);
                $sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
            }
        ];
    }
    
}
