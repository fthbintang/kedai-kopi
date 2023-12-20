<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class PresensiReport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithEvents
{
    use Exportable;

    // Penyimpanan data untuk diproses export
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    // Ini Header dari Excel (Baris Pertama / Pengenal)
    public function headings(): array
    {
        return [
            ['No', 'Nama Karyawan', 'Status', 'Date', 'Waktu Masuk', 'Waktu Keluar', 'Status Keterlambatan']
        ];
    }

    // Ini styling baris
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    // Ini Mapping, taruh semua data yang mau di tampilin ke sini. nama variable mengikuti output dari query yang ada di controller
    public function map($row): array
    {
        // Map your data to the corresponding columns

        static $no = 0;
        $no++;

        return [
            $no,
            $row->name,
            $row->user_status,
            $row->date,
            $row->waktu_masuk,
            $row->waktu_keluar,
            $row->is_late,
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet;
    
                // Menambahkan judul di atas tabel
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'Data Laporan Presensi');
    
                // Format judul (teks tebal dan rata tengah)
                $sheet->getStyle('A1:G1')->applyFromArray([
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
                $sheet->getStyle('A2:G' . $highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                // Contoh pengaturan ukuran kertas pada saat ekspor PDF
                $sheet->getDelegate()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getDelegate()->getPageSetup()->setFitToWidth(1);
                $sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
            }
        ];
    }

    // // Ini kalau mau nambah totalan di paling bawah, cuman harus di setting dimana letak nya.
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             // Get the highest row number
    //             $highestRow = $event->sheet->getHighestRow();

    //             // Calculate the total and add it to the total column
    //             $event->sheet->setCellValue("A$highestRow", 'Total');
    //             $event->sheet->setCellValue("B$highestRow", '=SUM(B2:B' . ($highestRow - 1) . ')');
    //         },
    //     ];
    // }
}
