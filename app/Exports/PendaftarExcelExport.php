<?php

namespace App\Exports;

use App\Models\Pendaftaran;
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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PendaftarExcelExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithColumnFormatting, WithStyles
{
  protected $startDate;
  protected $endDate;

  public function __construct($startDate = null, $endDate = null)
  {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
  }

  // public function collection()
  // {
  //   $query = Pendaftaran::latest();

  //   if ($this->startDate && $this->endDate) {
  //     $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
  //   }

  //   return $query->select(
  //     'nama_balita',
  //     'nik',
  //     'jenis_kelamin',
  //     'rt',
  //     'rw',
  //     'dukuh',
  //     'tanggal_lahir',
  //     'bb_lahir',
  //     'nama_ortu',
  //     'jadwal_id',
  //     'created_at',
  //     'tinggi_badan'
  //   )->get();
  // }

  public function collection()
  {
    return Pendaftaran::whereBetween('pendaftarans.created_at', [$this->startDate, $this->endDate])
      ->leftJoin('anthropometris', 'pendaftarans.id', '=', 'anthropometris.pendaftaran_id') // Left join tabel anthropometri
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
      strtoupper($pendaftaran->tanggal_lahir),
      strtoupper($pendaftaran->bb_lahir),
      strtoupper($pendaftaran->nama_ortu),
      strtoupper($pendaftaran->jadwal->nama_posyandu ?? 'N/A'),
      strtoupper($pendaftaran->rt),
      strtoupper($pendaftaran->rw),
      strtoupper($pendaftaran->dukuh),
      $pendaftaran->created_at->format('Y-m-d'),
      strtoupper($pendaftaran->berat_badan),
      strtoupper($pendaftaran->tinggi_badan),
      strtoupper($pendaftaran->z_score),
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
      'UMUR (BULAN)',
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
    $sheet->getStyle('A1:P1')->applyFromArray([
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

    return [
      'A' => ['alignment' => ['horizontal' => 'center']],
    ];
  }
}
