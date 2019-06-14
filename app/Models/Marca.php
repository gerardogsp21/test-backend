<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use softDeletes;

    protected $table = "marcas";
    protected $fillable = [
        "nombre",
        "referencia",
     ];

     public function productos() {
        return $this->hasMany('App\Models\Producto', 'marca_id');
    }
}
