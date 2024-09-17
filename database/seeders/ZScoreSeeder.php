<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ZScoreSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $zScores = range(3, -3, -1);

    foreach ($zScores as $zScore) {
      DB::table('z_scores')->insert([
        'nilai' => $zScore,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
