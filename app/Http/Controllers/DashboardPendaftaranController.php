<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Main;
use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Jadwal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class DashboardPendaftaranController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    // $user_id = auth()->user()->username;
    // $pendaftarans = Pendaftaran::latest() // Urutkan berdasarkan kolom created_at secara descending
    //   ->paginate(5);

    $user = auth()->user();
    $posyandu = Jadwal::all();


    if ($user->role == 'petugas') {
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
      $pendaftarans = $pendaftarans->paginate(10);
    } elseif ($user->role == 'ortu') {
      $pendaftarans = Pendaftaran::where('username', $user->username)->get();
    }

    return view('content.dashboard.pendaftaran.index', compact('pendaftarans', 'posyandu'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $posyanduList = Jadwal::pluck('nama_posyandu', 'id');
    return view('content.dashboard.pendaftaran.create', compact('posyanduList'));
  }

  public function hapus($id)
  {
    $result = Main::Hapus('pendaftarans', ['id' => $id]);
    if ($result == 1) {
      return redirect('/dashboard/pendaftaran')->with('success', 'Data pendaftaran berhasil dihapus.');
    } else {
      return redirect('/dashboard/pendaftaran')->with('error', 'Gagal menghapus data pendaftaran.');
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'nama_posyandu' => 'required|string|max:20',
      'nik' => 'required|string|max:16|unique:pendaftarans,nik',
      'nama_balita' => 'required|string|max:100',
      'tempat_lahir' => 'required|string|max:20',
      'tanggal_lahir' => 'required|date_format:Y-m-d',
      'jenis_kelamin' => 'required|string|max:50',
      'bb_lahir' => 'required|numeric|min:0|max:99.99',
      'nama_ortu' => 'required|string|max:255',
      'no_telepon' => 'required|string|max:13',
      'dukuh' => 'required|string|max:20',
      'rt' => 'required|string|max:3',
      'rw' => 'required|string|max:3',
      'pekerjaan' => 'required|string|max:50',
    ]);

    // Cari jadwal_id berdasarkan nama_posyandu
    $jadwal = Jadwal::where('nama_posyandu', $request->input('nama_posyandu'))->first();
    if (!$jadwal) {
      return redirect('/dashboard/pendaftaran/create')->with('error', 'Nama posyandu tidak valid.');
    }

    $validatedData['jadwal_id'] = $jadwal->id;
    $validatedData['username'] = auth()->user()->username;


    try {
      Pendaftaran::create($validatedData);
      return redirect('/dashboard/pendaftaran')->with('success', 'Data pendaftaran berhasil disimpan.');
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return redirect('/dashboard/pendaftaran/create')->with('error', 'Data pendaftaran tidak berhasil disimpan. Kesalahan: ' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $pendaftaran = Pendaftaran::find($id);

    if (!$pendaftaran) {
      return redirect('/dashboard/pendaftaran')->with('error', 'Data pendaftaran tidak ditemukan.');
    }

    return view('content.dashboard.pendaftaran.detail', compact('pendaftaran'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $pendaftarans = Pendaftaran::findOrFail($id);
    $posyanduList = Pendaftaran::pluck('nama_posyandu', 'id');
    return view('content.dashboard.pendaftaran.edit', compact(['pendaftarans', 'posyanduList']));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'nik' => 'required|digits:16|unique:pendaftarans,nik,' . $id,
      // validasi lainnya
    ], [
      'nik.unique' => 'NIK sudah terdaftar.',
      // pesan kesalahan lainnya
    ]);

    $pendaftaran = Pendaftaran::findOrFail($id);
    $pendaftaran->nama_posyandu = $request->nama_posyandu;
    $pendaftaran->nik = $request->nik;
    $pendaftaran->nama_balita = $request->nama_balita;
    $pendaftaran->tempat_lahir = $request->tempat_lahir;
    $pendaftaran->tanggal_lahir = $request->tanggal_lahir;
    $pendaftaran->jenis_kelamin = $request->jenis_kelamin;
    $pendaftaran->bb_lahir = $request->bb_lahir;
    $pendaftaran->nama_ortu = $request->nama_ortu;
    $pendaftaran->no_telepon = $request->no_telepon;
    $pendaftaran->dukuh = $request->dukuh;
    $pendaftaran->rt = $request->rt;
    $pendaftaran->rw = $request->rw;
    $pendaftaran->pekerjaan = $request->pekerjaan;

    $pendaftaran->save();

    if ($pendaftaran) {
      return redirect('/dashboard/pendaftaran')->with('success', 'Data pendaftaran berhasil disimpan.');
    } else {
      return redirect('/dashboard/pendaftaran')->with('error', 'Data pendaftaran tidak berhasil disimpan.');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  public function getDataByNik($nik)
  {
    $pendaftaran = Pendaftaran::where('nik', $nik)->first();

    if ($pendaftaran) {
      return response()->json([
        'nama_balita' => $pendaftaran->nama_balita,
        'jenis_kelamin' => $pendaftaran->jenis_kelamin
      ]);
    } else {
      return response()->json(['error' => 'NIK tidak ditemukan.'], 404);
    }
  }
}
