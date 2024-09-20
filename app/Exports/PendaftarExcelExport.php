<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PendaftarExcelExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithColumnFormatting, WithStyles, WithCustomStartCell
{
  protected $startDate;
  protected $endDate;

  public function __construct($startDate = null, $endDate = null)
  {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
  }

  public function collection()
  {
    return Pendaftaran::whereBetween('pendaftarans.created_at', [$this->startDate, $this->endDate])
      ->join('anthropometris', 'pendaftarans.id', '=', 'anthropometris.pendaftaran_id') //hanya data yg sudah ada di anthropo sj.
      ->select(
        'pendaftarans.nama_balita',
        'pendaftarans.nik',
        'pendaftarans.jenis_kelamin',
        'pendaftarans.rt',
        'pendaftarans.rw',
        'pendaftarans.dukuh',
        'pendaftarans.tanggal_lahir',
        'pendaftarans.bb_lahir',
        'pendaftarans.nama_ortu',
        'pendaftarans.jadwal_id',
        'pendaftarans.created_at',
        'anthropometris.berat_badan',
        'anthropometris.tinggi_badan',
        'anthropometris.z_score',
        'anthropometris.usia',
      )
      ->get();
  }



  public function map($pendaftaran): array
  {
    static $rowNumber = 1; // Initialize row number


    return [
      $rowNumber++, // Nomor urut
      "'" . $pendaftaran->nik,
      strtoupper($pendaftaran->nama_balita),
      strtoupper($pendaftaran->jenis_kelamin),
      $pendaftaran->tanggal_lahir ? Carbon::parse($pendaftaran->tanggal_lahir)->format('d/m/Y') : 'N/A',
      strtoupper($pendaftaran->bb_lahir),
      strtoupper($pendaftaran->nama_ortu),
      strtoupper($pendaftaran->jadwal->nama_posyandu ?? 'N/A'),
      strtoupper($pendaftaran->rt),
      strtoupper($pendaftaran->rw),
      strtoupper($pendaftaran->dukuh),
      $pendaftaran->created_at ? Carbon::parse($pendaftaran->created_at)->format('d/m/Y') : 'N/A',
      strtoupper($pendaftaran->berat_badan),
      strtoupper($pendaftaran->tinggi_badan),
      number_format($pendaftaran->z_score, 2, '.', ''),
      strtoupper($pendaftaran->usia),
    ];
  }

  // Heading
  public function headings(): array
  {
    return [
      'NO',
      'NIK',
      'NAMA',
      'JK',
      'TGL LAHIR',
      'BB LAHIR',
      'NAMA ORTU',
      'POSYANDU',
      'RT',
      'RW',
      'ALAMAT',
      'TGL DAFTAR',
      'BERAT',
      'TINGGI',
      'ZS TB/U',
      'USIA (BULAN)',
    ];
  }


  public function columnFormats(): array
  {
    return [
      'B' => NumberFormat::FORMAT_TEXT, // Format kolom NIK teks
      'G' => NumberFormat::FORMAT_TEXT,
    ];
  }

  // Styling untuk heading
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle('A2:P2')->applyFromArray([
      'font' => [
        'bold' => true,
        'color' => ['rgb' => '000000'], // grey
        'size' => 10,
        'allCaps' => true,
      ],
      'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'D3D3D3'],
      ],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      ],
    ]);

    $sheet->mergeCells('A1:P1');
    $sheet->setCellValue('A1', 'Data periode tanggal ' . $this->startDate . ' s/d ' . $this->endDate);

    $sheet->getStyle('A1')->applyFromArray([
      'font' => [
        'size' => 12,
      ],
    ]);

    return [
      'A' => ['alignment' => ['horizontal' => 'center']],
    ];
  }

  public function startCell(): string
  {
    return 'A2';
  }
}