<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    use HasFactory;
    
    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function documento()
    {
        return $this->hasMany(Documento::class, 'id_documento');
    }
}
