<?php

namespace App\Http\Controllers\main_dashboard;

use Carbon\Carbon;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\Anthropometri;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pertumbuhan;

class DashboardPetugasController extends Controller
{
  public function petugas()
  {
    $now = Carbon::now('Asia/Jakarta')->format('l, d/m/y, h:i:s');

    $totalLaki = Pendaftaran::where('jenis_kelamin', 'Laki-laki')->count();
    $totalPerempuan = Pendaftaran::where('jenis_kelamin', 'Perempuan')->count();

    $currentYear = date('Y');

    $stuntingData = Pertumbuhan::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
      ->where('status_stunting', 'Stunting')
      ->whereYear('created_at', $currentYear)
      ->groupBy(DB::raw('MONTH(created_at)'))
      ->orderBy('month')
      ->pluck('count', 'month');
    // dd($stuntingData);

    $normalData = Pertumbuhan::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
      ->where('status_stunting', 'Normal')
      ->whereYear('created_at', $currentYear)
      ->groupBy(DB::raw('MONTH(created_at)'))
      ->orderBy('month')
      ->pluck('count', 'month');

    $months = [];
    $stuntingCounts = [];
    $normalCounts = [];

    for ($month = 1; $month <= 12; $month++) {
      $months[] = date('M', mktime(0, 0, 0, $month, 1));
      $stuntingCounts[] = $stuntingData->get($month, 0);
      $normalCounts[] = $normalData->get($month, 0);
    }

    $data = [
      'months' => $months,
      'stunting' => $stuntingCounts,
      'normal' => $normalCounts
    ];
    // dd($data);



    // dd($normalData);


    return view('content.dashboard.dashboard-petugas', compact(
      'totalLaki',
      'totalPerempuan',
      'now',
      'data'
    ));
  }
}
