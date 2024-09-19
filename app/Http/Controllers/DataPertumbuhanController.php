<?php

namespace App\Http\Controllers;

use App\Models\Anthropometri;
use App\Models\Pertumbuhan;
use Illuminate\Http\Request;

class DataPertumbuhanController extends Controller
{

  /**
   * Store a newly created resource in storage.
   */

  public function calculateStunting($tinggiBadan, $usiaBulan, $beratBadan)
  {
    $dataTinggiBadan = [
      0 => [44.2, 46.1, 48, 49.9, 51.8, 53.7, 55.6],
      1 => [48.9, 50.8, 52.8, 54.7, 56.7, 58.6, 60.6],
      2 => [52.4, 54.4, 56.4, 58.4, 60.4, 62.4, 64.4],
      3 => [57.6, 59.7, 61.8, 63.9, 66, 68, 70.1],
      4 => [59.6, 61.7, 63.8, 65.9, 68, 70.1, 72.2],
      5 => [61.2, 63.3, 65.5, 67.6, 69.8, 71.9, 74],
      6 => [62.7, 64.8, 67, 69.2, 71.3, 73.5, 75.7],
      7 => [64, 66.2, 68.4, 70.6, 72.8, 75, 77.2],
      8 => [65.2, 67.5, 69.7, 72, 74.2, 76.5, 78.7],
      9 => [66.4, 68.7, 71, 73.3, 75.6, 77.9, 80.1],
      10 => [67.6, 69.9, 72.2, 74.5, 76.9, 79.2, 81.5],
      11 => [68.6, 71, 73.4, 75.7, 78.1, 80.5, 82.9],
      12 => [69.6, 72.1, 74.5, 76.9, 79.3, 81.8, 84.2],
      13 => [70.6, 73.1, 75.6, 78, 80.5, 83, 85.5],
      14 => [71.6, 74.1, 76.6, 79.1, 81.7, 84.2, 86.7],
      15 => [72.5, 75, 77.6, 80.2, 82.8, 85.4, 88],
      16 => [73.3, 76, 78.6, 81.2, 83.9, 86.5, 89.2],
      17 => [74.2, 76.9, 79.6, 82.3, 85, 87.7, 90.4],
      18 => [75, 77.7, 80.5, 83.2, 86, 88.8, 91.5],
      19 => [75.8, 78.6, 81.4, 84.2, 87, 89.8, 92.6],
      20 => [76.5, 79.4, 82.3, 85.1, 88, 90.9, 93.8],
      21 => [77.2, 80.2, 83.1, 86, 89, 91.9, 94.9],
      22 => [78, 81, 83.9, 86.9, 89.9, 92.9, 95.9],
      23 => [78.7, 81.7, 84.8, 87.8, 90.9, 93.9, 97],
      24 => [78, 81, 84.1, 87.1, 90.2, 93.2, 96.3],
      25 => [78.6, 81.7, 84.9, 88, 91.1, 94.2, 97.3],
      26 => [79.3, 82.5, 85.6, 88.8, 92, 95.2, 98.3],
      27 => [79.9, 83.1, 86.4, 89.6, 92.9, 96.1, 99.3],
      28 => [80.5, 83.8, 87.1, 90.4, 93.7, 97, 100.3],
      29 => [81.1, 84.5, 87.8, 91.2, 94.5, 97.9, 101.2],
      30 => [81.7, 85.1, 88.5, 91.9, 95.3, 98.7, 102.1],
      31 => [82.3, 85.7, 89.2, 92.7, 96.1, 99.6, 103],
      32 => [82.8, 86.4, 89.9, 93.4, 96.9, 100.4, 103.9],
      33 => [83.4, 86.9, 90.5, 94.1, 97.6, 101.2, 104.8],
      34 => [83.9, 87.5, 91.1, 94.8, 98.4, 102, 105.6],
      35 => [84.4, 88.1, 91.8, 95.4, 99.1, 102.7, 106.4],
      36 => [85, 88.7, 92.4, 96.1, 99.8, 103.5, 107.2],
      37 => [85.5, 89.2, 93, 96.7, 100.5, 104.2, 108],
      38 => [86, 89.8, 93.6, 97.4, 101.2, 105, 108.8],
      39 => [86.5, 90.3, 94.2, 98, 101.8, 105.7, 109.5],
      40 => [87, 90.9, 94.7, 98.6, 102.5, 106.4, 110.3],
      41 => [87.5, 91.4, 95.3, 99.2, 103.2, 107.1, 111],
      42 => [88, 91.9, 95.9, 99.9, 103.8, 107.8, 111.7],
      43 => [88.4, 92.4, 96.4, 100.4, 104.5, 108.5, 112.5],
      44 => [88.9, 93, 97, 101, 105.1, 109.1, 113.2],
      45 => [89.4, 93.5, 97.5, 101.6, 105.7, 109.8, 113.9],
      46 => [89.8, 94, 98.1, 102.2, 106.3, 110.4, 114.6],
      47 => [90.3, 94.4, 98.6, 102.8, 106.9, 111.1, 115.2],
      48 => [90.7, 94.9, 99.1, 103.3, 107.5, 111.7, 115.9],
      49 => [91.2, 95.4, 99.7, 103.9, 108.1, 112.4, 116.6],
      50 => [91.6, 95.9, 100.2, 104.4, 108.7, 113, 117.3],
      51 => [92.1, 96.4, 100.7, 105, 109.3, 113.6, 117.9],
      52 => [92.5, 96.9, 101.2, 105.6, 109.9, 114.2, 118.6],
      53 => [93, 97.4, 101.7, 106.1, 110.5, 114.9, 119.2],
      53 => [93, 97.4, 101.7, 106.1, 110.5, 114.9, 119.2],
      54 => [93.4, 97.8, 102.3, 106.7, 111.1, 115.5, 119.9],
      55 => [93.9, 98.3, 102.8, 107.2, 111.7, 116.1, 120.6],
      56 => [94.3, 98.8, 103.3, 107.8, 112.3, 116.7, 121.2],
      57 => [94.7, 99.3, 103.8, 108.3, 112.8, 117.4, 121.9],
      58 => [95.2, 99.7, 104.3, 108.9, 113.4, 118.0, 122.6],
      59 => [95.6, 100.2, 104.8, 109.4, 114.0, 118.6, 123.2],
      60 => [96.1, 100.7, 105.3, 110.0, 114.6, 119.2, 123.9]
    ];

    if ($usiaBulan < 0 || $usiaBulan > 60) {
      return [
        'status' => 'Usia tidak valid',
        'status_gizi' => 'N/A',
        'zscore' => 'N/A',
        'keterangan' => 'Usia balita sudah tidak memenuhi ambang batas perhitungan stunting.'
      ];
    }

    $data = $dataTinggiBadan[$usiaBulan] ?? null;


    if ($data) {
      // Z-Score berdasarkan tinggi badan
      $median = $data[3]; // Median (nilai ke -4)
      $plus2SD = $data[5];
      $minus2SD = $data[1];

      // Hitung z-score
      $zScore = ($tinggiBadan - $median) / ($plus2SD - $median);

      if ($zScore < -3) {
        $status = 'Stunting';
      } elseif ($zScore >= -3 && $zScore < -2) {
        $status = 'Stunting';
      } elseif ($zScore >= -2 && $zScore <= 3) {
        $status = 'Normal';
      } else {
        $status = 'Tinggi';
      }

      //  z-score
      if ($zScore < -3) {
        $keterangan = 'sangat pendek (severely stunted)';
      } elseif ($zScore >= -3 && $zScore < -2) {
        $keterangan = 'pendek (stunted)';
      } elseif ($zScore >= -2 && $zScore <= 3) {
        $keterangan = 'normal';
      } else {
        $keterangan = 'tinggi';
      }

      return [
        'status' => $status,
        'zscore' => $zScore,
        'status_gizi' => $keterangan,

        //deskripsi detail keterangan.
        'keterangan' => sprintf(
          '- Hasil perhitungan Z-Score: <span class="text-primary"> %.2f</span> <br>' .
            ' - Berat badan balita terakhir: %s kg<br>' .
            '- Tinggi badan balita terakhir: %d cm<br>' .
            '- Balita dengan kategori status gizi %s',
          $zScore,
          $beratBadan,
          $tinggiBadan,
          $keterangan
        )
      ];
    } else {
      return [
        'status' => 'Data tinggi badan tidak ditemukan untuk usia ini',
        'keterangan' => ''
      ];
    }
  }

  public function store(Request $request)
  {

    $bulan = $request->input('bulan');
    $parts = explode('-', $bulan);
    $tahun = intval($parts[0]);
    $bulan = intval($parts[1]);

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

    $latestData = Anthropometri::where('id', $request->anthropometri_id)->first();

    // rumus selisih usia
    if ($latestData) {
      $createdAt = $latestData->created_at;

      $latestBulan = $createdAt->format('m');
      $latestTahun = $createdAt->format('Y');

      // hitung selisih bulan
      $selisihTahun = $tahun - $latestTahun;
      $selisihBulan = $bulan - $latestBulan;

      $totalSelisih = ($selisihTahun * 12) + $selisihBulan;

      $nowAge = $latestData->usia + $totalSelisih;
      $validatedData['usia'] = $nowAge;
    }

    $stuntingResult = $this->calculateStunting(
      $validatedData['tinggi_badan'],
      $validatedData['usia'],
      $validatedData['berat_badan']
    );

    $validatedData['status_stunting'] = $stuntingResult['status'];
    $validatedData['status_gizi'] = $stuntingResult['status_gizi'];
    $validatedData['z_score'] = $stuntingResult['zscore'];

    //dd($validatedData);

    Pertumbuhan::create($validatedData);

    return redirect()->back()->with('success', 'Data berhasil disimpan.');
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
