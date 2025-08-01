<?php

namespace App\Exports\Kolektor;

use App\Models\Penerimaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class DataExcel implements FromCollection, WithHeadings, WithStyles
{
    protected $hasilinfaq;
    protected $filterOption;
    protected $tanggal;
    protected $months;
    protected $tahun;
    protected $showAll;

    public function __construct($hasilinfaq, $filterOption, $tanggal, $months, $tahun, $showAll)
    {
        $this->hasilinfaq = $hasilinfaq;
        $this->filterOption = $filterOption;
        $this->tanggal = $tanggal;
        $this->months = $months;
        $this->tahun = $tahun;
        $this->showAll = $showAll;
    }

    public function collection()
    {
        $data = $this->hasilinfaq;

        // Hitung total nominal
        $totalNominal = $data->sum(function ($item) {
            return is_numeric($item->jumlah ?? 0) ? $item->jumlah : 0;
        });

        // Format data untuk Excel
        $collection = $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nama Kolektor' => $item->user->username ?? '-',
                'Tanggal Kirim' => $item->tglSetor ? Carbon::parse($item->tglSetor)->format('d-m-Y') : '-',
                'Kecamatan' => $item->plotting->kecamatan->nama_kecamatan ?? '-',
                'Kelurahan' => $item->plotting->kelurahan->nama_kelurahan ?? '-',
                'RT/RW' => ($item->Rt ?? '-') . '/' . ($item->Rw ?? '-'),
                'Nominal Infaq' => 'Rp. ' . number_format($item->nominal ?? 0, 0, ',', '.'),
                'Jumlah' => 'Rp. ' . number_format($item->jumlah ?? 0, 0, ',', '.'),
                'Nama Bank' => $item->namaBank ?? '-',
                'Rekening' => $item->Rekening ?? '-',
            ];
        });

        // Tambahkan baris total nominal
        $collection->push([
            'No' => '',
            'Nama Kolektor' => '',
            'Tanggal Setor' => '',
            'Kecamatan' => '',
            'Kelurahan' => '',
            'RT/RW' => '',
            'Nominal' => '',
            'Nama Bank' => '',
            'Rekening' => 'Total:',
            'Jumlah' => 'Rp. ' . number_format($totalNominal ?? 0, 0, ',', '.'),
        ]);

        return $collection;
    }

    public function headings(): array
    {
        return [
            [
                'No',
                'Nama Kolektor',
                'Tanggal Setor',
                'Wilayah Infaq',
                '',
                '',
                'Nominal Infaq',
                'Jumlah',
                'Nama Bank',
                'Rekening',
            ],
            [
                '',
                '',
                '',
                'Kecamatan',
                'Kelurahan',
                'RT/RW',
                '',
                '',
                '',
                '',
            ],
        ];
    }

    public function title(): string
    {
        // Menentukan teks periode berdasarkan filterOption
        $periodeText = 'Laporan Hasil Setoran';

        if ($this->showAll) {
            $periodeText .= ' - Semua Periode';
        } elseif ($this->filterOption === 'custom' && $this->tanggal) {
            $periodeText .= ' - Tanggal ' . $this->tanggal;
        } elseif ($this->filterOption === 'monthly' && $this->months && $this->tahun) {
            $periodeText .= ' - Bulan ' . $this->months . ' ' . $this->tahun;
        } elseif ($this->filterOption === 'quarterly' && $this->tahun) {
            $periodeText .= ' - Triwulan ' . $this->tahun;
        } elseif ($this->filterOption === 'semiannual' && $this->tahun) {
            $periodeText .= ' - Semesteran ' . $this->tahun;
        } elseif ($this->filterOption === 'yearly' && $this->tahun) {
            $periodeText .= ' - Tahunan ' . $this->tahun;
        } else {
            $periodeText .= ' - Harian ' . Carbon::today()->format('d-m-Y');
        }

        return $periodeText;
    }

    public function styles(Worksheet $sheet)
    {
        // Geser header dan data ke bawah untuk memberi ruang pada judul
        $sheet->insertNewRowBefore(1, 2); // Tambahkan 2 baris kosong di atas

        // Set judul di baris pertama
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', $this->title());
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style untuk header (sekarang di baris 3 dan 4)
        $sheet->getStyle('A3:J4')->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '4B8BF5', // Biru muda
                ],
            ],
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFF'], // Teks putih
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Menggabungkan sel untuk "Wilayah" (kolom D3-F3)
        $sheet->mergeCells('D3:F3');

        // Menggabungkan sel secara vertikal untuk kolom No, Nama Kolektor, Tanggal Setor, Jumlah, Nominal
        $columnsToMerge = ['A', 'B', 'C', 'G', 'H', 'I', 'J'];
        foreach ($columnsToMerge as $column) {
            $sheet->mergeCells("{$column}3:{$column}4");
        }

        // Style untuk data (baris 5 ke bawah)
        $sheet->getStyle('A5:H' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Auto-size kolom dengan lebar minimum
        $columnWidths = [
            'A' => 5,   // No
            'B' => 20,  // Nama Kolektor
            'C' => 15,  // Tanggal Setor
            'D' => 20,  // Kecamatan
            'E' => 20,  // Kelurahan
            'F' => 10,  // RT/RW
            'G' => 20,  // Jumlah
            'H' => 20,  // Nominal
            'I' => 20,  // Nominal
            'J' => 20,  // Nominal
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Tinggi baris untuk judul
        $sheet->getRowDimension(1)->setRowHeight(40);

        // Tinggi baris untuk header
        $sheet->getRowDimension(3)->setRowHeight(30);
        $sheet->getRowDimension(4)->setRowHeight(20);

        // Tinggi baris untuk data
        for ($row = 5; $row <= $sheet->getHighestRow(); $row++) {
            $sheet->getRowDimension($row)->setRowHeight(25);
        }

        // Format kolom Nominal sebagai mata uang
        $sheet->getStyle('H5:H' . $sheet->getHighestRow())->getNumberFormat()
            ->setFormatCode('#,##0');

        return [];
    }
}
