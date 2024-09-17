<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\View\View;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
  function index(): View
  {
    $username = auth()->user()->username;
    $pendaftaran = Pendaftaran::where('username', $username)->first();

    $tglLahir  = $pendaftaran?->tanggal_lahir;
    $tglLahir = Carbon::parse($tglLahir);
    $usia = $tglLahir->diffInMonths(Carbon::now());


    return view('content.dashboard.notifications.index', compact('pendaftaran', 'usia'));
  }
}
