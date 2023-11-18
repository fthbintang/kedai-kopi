<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

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
            ['No', 'Nama Karyawan', 'Status', 'Date', 'Gaji', 'Status Gaji']
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
            $row->gaji,
            $row->is_paid,
        ];
    }

    // Calculate totals for each column
    private function calculateTotals()
    {
        $totals = new \stdClass();
        $totals->name = 'Total Gaji'; // Or you can set it to 'Grand Total' or something else
        $totals->user_status = null; // You may adjust this based on your data type
        $totals->date = null;
        $totals->gaji = collect($this->data)->sum('gaji');
        $totals->is_paid = null;
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

                $totals = $this->calculateTotals();
                $event->sheet->append([$totals->name, $totals->user_status, $totals->date, $totals->date, $totals->gaji, $totals->is_paid]);

                $event->sheet->getDelegate()->getStyle("E2:E$highestRow")->getNumberFormat()->setFormatCode('_("Rp. "* #,##0.00_);_("Rp. "* -#,##0.00_)');
            },
        ];
    }
}
