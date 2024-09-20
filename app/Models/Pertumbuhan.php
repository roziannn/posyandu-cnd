<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertumbuhan extends Model
{
  use HasFactory;
  protected $fillable = [
    'pendaftaran_id',
    'anthropometri_id',
    'bulan',
    'tahun',
    'tinggi_badan',
    'berat_badan',
    'cara_ukur',
    'status_stunting',
    'status_gizi',
    'usia',
    'z_score',
  ];

  public function pendaftaran()
  {
    return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
  }
}
