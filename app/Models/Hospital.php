<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = ['kode_rs', 'nama_rs', 'alamat_rs', 'status_rs'];
}