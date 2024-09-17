<?php

namespace App\Http\Controllers\main_dashboard;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardOrtuController extends Controller
{
  function index()
  {
    $totalLaki = Pendaftaran::where('jenis_kelamin', 'Laki-laki')->count();
    $totalPerempuan = Pendaftaran::where('jenis_kelamin', 'Perempuan')->count();

    return view('content.dashboard.dashboard-ortu', compact('totalLaki', 'totalPerempuan'));
  }
}
