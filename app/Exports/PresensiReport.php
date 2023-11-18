<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PresensiReport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison
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
