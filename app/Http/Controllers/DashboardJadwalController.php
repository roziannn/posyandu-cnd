<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Main;
use App\Models\Post;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardJadwalController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    // $user_id = auth()->user()->username;
    // $jadwals = Jadwal::where('username', $user_id)
    //   ->orderBy('created_at', 'desc')
    //   ->paginate(5);

    $search = $request->input('search');

    $jadwals = Jadwal::latest();

    if ($search) {
      $jadwals = $jadwals->where(function ($query) use ($search) {
        $query->where('nama_posyandu', 'like', '%' . $search . '%')
          ->orWhere('dukuh', 'like', '%' . $search . '%');
      });
    }

    // Pagination
    $jadwals = $jadwals->paginate(20);

    // dd($jadwals);

    return view('content.dashboard.jadwal.index', compact('jadwals'));
  }

  /**
   * Show the form for creating a new resource.
   */

  public function hapusjadwal($id)
  {
    $result = Main::Hapus('jadwals', ['id' => $id]);
    if ($result == 1) {
      return redirect('/dashboard/jadwal')->with('success', 'Data jadwal berhasil dihapus.');
    } else {
      return redirect('/dashboard/jadwal')->with('error', 'Gagal menghapus data jadwal.');
    }
  }
  public function create()
  {

    return view('content.dashboard.jadwal.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    $validatedData = $request->validate([
      'nama_posyandu' => 'required|string|max:50',
      'dukuh' => 'required|string|max:20',
      'rt' => 'required|string|max:3',
      'rw' => 'required|string|max:3',
      'tanggal' => 'required|date_format:Y-m-d',
      'jam_mulai' => 'required|date_format:H:i',
      'jam_selesai' => 'required|date_format:H:i'
    ]);

    // Tambahkan username ke dalam data yang akan disimpan
    $validatedData['username'] = auth()->user()->username;

    try {
      // Simpan data menggunakan Eloquent
      $jadwal = Jadwal::create($validatedData);

      if ($jadwal) {
        // Redirect dengan pesan sukses
        return redirect('/dashboard/jadwal')->with('success', 'Data jadwal berhasil disimpan.');
      } else {
        // Redirect dengan pesan error jika gagal menyimpan
        return redirect('/dashboard/jadwal')->with('error', 'Gagal menyimpan data jadwal.');
      }
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return redirect('/dashboard/jadwal/create')->with('error', 'Data jadwal tidak berhasil disimpan. Kesalahan: ' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $jadwal = Jadwal::find($id);

    if (!$jadwal) {
      return redirect('/dashboard/jadwal')->with('error', 'Data jadwal tidak ditemukan.');
    }

    return view('content.dashboard.jadwal.detail', compact('jadwal'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $jadwals = Jadwal::findOrFail($id);
    return view('content.dashboard.jadwal.edit', compact(['jadwals']));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $jadwal = Jadwal::findOrFail($id);
    $jadwal->nama_posyandu = $request->nama_posyandu;
    $jadwal->dukuh = $request->dukuh;
    $jadwal->rt = $request->rt;
    $jadwal->rw = $request->rw;
    $jadwal->tanggal = $request->tanggal;
    $jadwal->jam_mulai = $request->jam_mulai;
    $jadwal->jam_selesai = $request->jam_selesai;
    $jadwal->save();

    if ($jadwal) {
      return redirect('/dashboard/jadwal')->with('success', 'Data jadwal berhasil disimpan.');
    } else {
      return redirect('/dashboard/jadwal')->with('error', 'Data jadwal tidak berhasil disimpan.');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
