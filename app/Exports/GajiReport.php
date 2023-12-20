<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PHPUnit\Framework\Attributes\Before;

class GajiReport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithStrictNullComparison, WithEvents
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
            ['No', 'Nama Karyawan', 'Status', 'Date', 'Status Gaji', 'Gaji']
        ];
    }

    // Ini styling baris
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
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
            $row->is_paid,
            $row->gaji,
        ];
    }

    // Calculate totals for each column
    private function calculateTotals()
    {
        $totals = new \stdClass();
        $totals->name = 'Total Gaji'; // Or you can set it to 'Grand Total' or something else
        $totals->user_status = null; // You may adjust this based on your data type
        $totals->date = null;
        $totals->is_paid = null;
        $totals->gaji = collect($this->data)->sum('gaji');
        // dd($totals);
        return $totals;
    }

    // Ini kalau mau nambah totalan di paling bawah, cuman harus di setting dimana letak nya.
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Get the highest row number
                $highestRow = $event->sheet->getHighestRow() + 1;
                $sheet = $event->sheet;
                // $highestRowBaru = $sheet->getHighestRow();

                $totals = $this->calculateTotals();
                $event->sheet->append([$totals->name, $totals->user_status, $totals->date, $totals->date, $totals->is_paid, $totals->gaji]);

                $event->sheet->getDelegate()->mergeCells("A$highestRow:E$highestRow")->getStyle("F2:F$highestRow")->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* -#,##0.00_)');

                $sheet->getStyle('A2:F' . $highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $sheet->mergeCells('A1:F1'); // Sesuaikan dengan range atau kolom yang diinginkan
                $sheet->setCellValue('A1', 'Laporan Gaji'); // Set nilai untuk sel yang digabungkan
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Mengatur rata tengah horizontal

                // Menambahkan judul di atas tabel
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'Data Laporan Gaji Karyawan');
    
                // Format judul (teks tebal dan rata tengah)
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
