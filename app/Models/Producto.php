<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DBAL\TimestampType;

class Producto extends Model
{
    //use HasFactory;
    protected $table = "productos";
    protected $primaryKey = "id_productos";
    public $timestamps = false;
}
