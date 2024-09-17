<?php

namespace App\Http\Controllers;

use App\Models\Anthropometri;
use App\Models\ZScore;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardPertumbuhanController extends Controller
{
  function index(): View
  {
    $user = Auth::user();

    $dataAnak = Anthropometri::join('pendaftarans', 'anthropometris.pendaftaran_id', '=', 'pendaftarans.id')
      ->where('pendaftarans.username', $user->username)
      ->select('anthropometris.*', 'pendaftarans.*')
      ->orderBy('anthropometris.created_at', 'desc')
      ->get();


    $ages = $dataAnak->pluck('usia')->first();
    $tinggiBadan = $dataAnak->pluck('tinggi_badan')->toArray();

    $zScoreLimits = ZScore::pluck('nilai')->toArray();
    $zScore = $dataAnak->pluck('z_score')->first();


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



    return view('content.dashboard.pertumbuhan.index', compact(
      'dataAnak',
      'zScoreLimits',
      'tinggiBadan',
      'zScore',
      'ages',
      'status_gizi'
    ));
  }

  function indexPetugas($id)
  {

    $data = Anthropometri::findOrFail($id);

    // dd($data);

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

    // dd($status_gizi);

    return view('content.dashboard.pertumbuhan.index-petugas', compact('data', 'status_gizi', 'zScoreLimits', 'zScore', 'ages'));
  }
}
