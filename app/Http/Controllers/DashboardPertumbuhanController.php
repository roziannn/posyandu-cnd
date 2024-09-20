<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ZScore;
use Illuminate\View\View;
use App\Models\Pertumbuhan;
use Illuminate\Http\Request;
use App\Models\Anthropometri;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardPertumbuhanController extends Controller
{
  function index(Request $request, $id): View
  {
    $data = Anthropometri::findOrFail($id);

    $ages = $data->usia;
    $zScoreLimits = ZScore::pluck('nilai')->toArray();

    $zScore = $data->z_score;
    // dd($zScore);


    $status_gizi = '';
    if ($zScore < -3) {
      $status_gizi = 'severely-stunted';
    } elseif ($zScore >= -3 && $zScore < -2) {
      $status_gizi = 'stunted';
    } elseif ($zScore >= -2 && $zScore <= 3) {
      $status_gizi = 'normal';
    } else {
      $status_gizi = 'tinggi';
    }

    $latestMonthData = Pertumbuhan::where('anthropometri_id', $data->id)
      ->select(DB::raw("MAX(CONCAT(LPAD(bulan, 2, '0'), '/', tahun)) as latest_month"))
      ->first();

    if ($latestMonthData && $latestMonthData->latest_month) {
      $selectedMonth = $request->input('month') ?? $latestMonthData->latest_month;
    } else {
      $selectedMonth = $request->input('month') ?? now()->format('m/Y');
    }

    $parsedDate = Carbon::createFromFormat('m/Y', $selectedMonth);


    /** Get grafik berdasarkan filter bulan
     */
    $getAllMonthsBased = Pertumbuhan::where('anthropometri_id', $data->id)
      ->select(DB::raw("CONCAT(LPAD(bulan, 2, '0'), '/', tahun) as month"))
      ->groupBy('month')
      ->pluck('month')
      ->toArray();


    // $selectedMonth = $request->input('month') ?? now()->format('m/Y');
    // $parsedDate = Carbon::createFromFormat('m/Y', $selectedMonth);

    $pertumbuhan = Pertumbuhan::where('anthropometri_id', $data->id)
      ->where('bulan', '=', $parsedDate->format('m'))
      ->where('tahun', '=', $parsedDate->format('Y'))
      ->get();


    $zScore = [];
    if ($pertumbuhan->isNotEmpty()) {
      foreach ($pertumbuhan as $item) {
        $zScore[] = $item->z_score;
      }
    } else {
      $zScore[] = null;
    }
    //dd($zScore);

    return view('content.dashboard.pertumbuhan.index', compact(
      'data',
      'status_gizi',
      'zScoreLimits',
      'zScore',
      'ages',
      'selectedMonth',
      'getAllMonthsBased'
    ));
  }

  function indexOrtu(): View  //list page
  {
    $user = Auth::user();

    $dataAnak = Anthropometri::join('pendaftarans', 'anthropometris.pendaftaran_id', '=', 'pendaftarans.id')
      ->where('pendaftarans.nama_ortu', $user->username)
      ->select('anthropometris.*', 'pendaftarans.*', 'anthropometris.id as anthropometri_id', 'pendaftarans.id as pendaftaran_id')
      ->orderBy('anthropometris.created_at', 'desc')
      ->get();

    $count = $dataAnak->count();
    // dd($count);

    return view('content.dashboard.pertumbuhan.index-ortu', compact('dataAnak', 'count'));
  }

  function indexPetugas(Request $request, $id)
  {

    $data = Anthropometri::findOrFail($id);

    $ages = $data->usia;
    $zScoreLimits = ZScore::pluck('nilai')->toArray();

    $zScore = $data->z_score;
    // dd($zScore);


    $status_gizi = '';
    if ($zScore < -3) {
      $status_gizi = 'severely-stunted';
    } elseif ($zScore >= -3 && $zScore < -2) {
      $status_gizi = 'stunted';
    } elseif ($zScore >= -2 && $zScore <= 3) {
      $status_gizi = 'normal';
    } else {
      $status_gizi = 'tinggi';
    }

    $latestMonthData = Pertumbuhan::where('anthropometri_id', $data->id)
      ->select(DB::raw("MAX(CONCAT(LPAD(bulan, 2, '0'), '/', tahun)) as latest_month"))
      ->first();

    if ($latestMonthData && $latestMonthData->latest_month) {
      $selectedMonth = $request->input('month') ?? $latestMonthData->latest_month;
    } else {
      $selectedMonth = $request->input('month') ?? now()->format('m/Y');
    }

    $parsedDate = Carbon::createFromFormat('m/Y', $selectedMonth);

    /** Get grafik berdasarkan bulan
     */
    $getAllMonthsBased = Pertumbuhan::where('anthropometri_id', $data->id)
      ->select(DB::raw("CONCAT(LPAD(bulan, 2, '0'), '/', tahun) as month"))
      ->groupBy('month')
      ->pluck('month')
      ->toArray();

    $pertumbuhan = Pertumbuhan::where('anthropometri_id', $data->id)
      ->where('bulan', '=', $parsedDate->format('m'))
      ->where('tahun', '=', $parsedDate->format('Y'))
      ->get();

    // dd($pertumbuhan);

    $zScore = [];
    if ($pertumbuhan->isNotEmpty()) {
      foreach ($pertumbuhan as $item) {
        $zScore[] = $item->z_score;
      }
    } else {
      $zScore[] = null;
    }
    //dd($zScore);

    return view('content.dashboard.pertumbuhan.index-petugas', compact(
      'data',
      'status_gizi',
      'zScoreLimits',
      'zScore',
      'ages',
      'selectedMonth',
      'getAllMonthsBased'
    ));
  }
}
