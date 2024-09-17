<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anthropometri extends Model
{
  use HasFactory;


  protected $table = 'anthropometris';

  protected $fillable = [
    'pendaftaran_id',
    'tinggi_badan',
    'berat_badan',
    'jenis_kelamin',

    'z_score',
    'usia',
    'status_stunting',
    'status_gizi',
  ];

  public function pendaftaran()
  {
    return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
  }
}
