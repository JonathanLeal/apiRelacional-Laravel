<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DBAL\TimestampType;

class Bodega extends Model
{
    //use HasFactory;
    protected $table = "bodegas";
    protected $primaryKey = "id_bodegas";
    public $timestamps = false;
}
