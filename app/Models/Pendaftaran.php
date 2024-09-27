<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
  use HasFactory;
  protected $guarded = ['id'];
  protected $fillable = [
    'jadwal_id',
    'nama_posyandu',
    'nik',
    'nama_balita',
    'tempat_lahir',
    'tanggal_lahir',
    'jenis_kelamin',
    'bb_lahir',
    'tb_lahir',
    'email_ortu',
    'nama_ortu',
    'no_telepon',
    'dukuh',
    'rt',
    'rw',
    'pekerjaan',
    'username'
  ];
  public static $rules = [
    'nik' => 'required|unique:pendaftarans,nik',
    // Definisikan aturan validasi lainnya jika diperlukan
  ];
  public static function pendaftaran_by($userId)
  {
    return static::query()
      ->where('username', $userId);
  }
  public function jadwal()
  {
    return $this->belongsTo(Jadwal::class, 'jadwal_id');
  }
  public function anthropometri()
  {
    return $this->hasOne(Anthropometri::class, 'pendaftaran_id', 'id');
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'username');
  }
}
