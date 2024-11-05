<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\View\View;
use App\Traits\Searchable;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftarExcelExport;

class LaporanController extends Controller
{
  function laporanPendaftarPosyandu(Request $request): View
  {
    $search = $request->input('search');
    $filterPosyandu = $request->input('filter_posyandu');

    $pendaftarans = Pendaftaran::latest();

    //$pendaftarans = Pendaftaran::with('anthropometri')->latest()->get();
    //  dd($pendaftarans);

    if ($search) {
      $pendaftarans = $pendaftarans->where(function ($query) use ($search) {
        $query->where('nama_balita', 'like', '%' . $search . '%')
          ->orWhere('nik', 'like', '%' . $search . '%');
      });
    }

    if ($filterPosyandu) {
      $pendaftarans = $pendaftarans->whereHas('jadwal', function ($query) use ($filterPosyandu) {
        $query->where('nama_posyandu', $filterPosyandu);
      });
    }

    // Pagination
    $pendaftarans = $pendaftarans->paginate(20);

    $posyandu = Jadwal::all();

    return view('content.dashboard.laporan.pendaftar-posyandu', compact('pendaftarans', 'posyandu'));
  }

  function exportExcel(Request $request)
  {
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    return Excel::download(new PendaftarExcelExport($startDate, $endDate), 'laporan_pendaftar_posyandu.xlsx');
  }

  // Method for PDF EXPORT
  protected $startDate;
  protected $endDate;

  public function __construct(Request $request)
  {
    $this->startDate = $request->query('start_date');
    $this->endDate = $request->query('end_date');
  }
  public function exportPdf()
  {

    $pendaftarans =  Pendaftaran::whereBetween('pendaftarans.created_at', [$this->startDate, $this->endDate])
      ->join('pertumbuhans', function ($join) {
        $join->on('pendaftarans.id', '=', 'pertumbuhans.pendaftaran_id')
          ->whereRaw('pertumbuhans.created_at = (
                SELECT MAX(p2.created_at)
                FROM pertumbuhans p2
                WHERE p2.pendaftaran_id = pertumbuhans.pendaftaran_id
            )');
      })
      ->select(
        'pendaftarans.*',
        'pertumbuhans.berat_badan',
        'pertumbuhans.tinggi_badan',
        'pertumbuhans.z_score',
        'pertumbuhans.usia',
        'pertumbuhans.status_gizi',
        'pertumbuhans.created_at as latest_pertumbuhan'
      )
      ->orderBy('latest_pertumbuhan', 'desc')
      ->get();

    $startDate = \Carbon\Carbon::parse($this->startDate)->format('d/m/Y');
    $endDate = \Carbon\Carbon::parse($this->endDate)->format('d/m/Y');
    $infoCetak = \Carbon\Carbon::now()->format('d/m/Y, h:i:s');

    $pdf = Pdf::loadView('content.dashboard.laporan.pendaftaran-pdf', [
      'pendaftarans' => $pendaftarans,
      'startDate' => $startDate,
      'endDate' => $endDate,
      'infoCetak' => $infoCetak,
    ])
      ->setPaper('a4', 'landscape');


    return $pdf->download('laporan_pendaftaran.pdf');
  }
}
