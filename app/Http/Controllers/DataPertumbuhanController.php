<?php

namespace App\Http\Controllers;

use App\Models\Pertumbuhan;
use Illuminate\Http\Request;

class DataPertumbuhanController extends Controller
{

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // dd($request->all());

    $bulan = $request->input('bulan');
    $parts = explode('-', $bulan);
    $tahun = $parts[0];
    $bulan = $parts[1];

    $validatedData = $request->validate([
      'tinggi_badan' => 'required|numeric|min:0|max:300',
      'berat_badan' => 'required|numeric|min:0|max:200',
    ]);

    $validatedData['bulan'] = $bulan;
    $validatedData['tahun'] = $tahun;
    $validatedData['tinggi_badan'] = $request->tinggi_badan;
    $validatedData['berat_badan'] = $request->berat_badan;
    $validatedData['pendaftaran_id'] = $request->pendaftaran_id;
    $validatedData['anthropometri_id'] = $request->anthropometri_id;
    $validatedData['cara_ukur'] = $request->cara_ukur;

    Pertumbuhan::create($validatedData);

    return redirect()->back()->with('success', 'Data berhasil disimpan.');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
