<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class Main extends Model
{
   public static function Simpan($table, $data)
   {
    return DB::table($table)->insert($data);;
   }

   public static function Edit($table,$data,$where)
   {
    return DB::table($table)->where($where)->update($data);;
   }

   public static function Hapus($table,$where)
   {
    return DB::table($table)->where($where)->delete();
   }
}