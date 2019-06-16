<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use softDeletes;

    protected $table = "productos";
    protected $fillable = [
        "nombre",
        "talla",
        "observaciones",
        "marca_id",
        "cantidad_inventario",
        "fecha_embarque"
     ];

     public function marca() {
        return $this->belongsTo('App\Models\Marca', 'marca_id');
    }
}
