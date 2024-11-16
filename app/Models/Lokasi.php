<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
  use HasFactory;
  protected $guarded = ['id'];
  protected $fillable = [
    'nama_posyandu',
    'dukuh',
    'rt',
    'rw',
    'username'
  ];
  public static function lokasi_by($userId)
  {
    return static::query()
      ->where('username', $userId);
  }

  public function pendaftaran()
  {
    return $this->hasOne(Pendaftaran::class, 'id_lokasi');
  }
}
