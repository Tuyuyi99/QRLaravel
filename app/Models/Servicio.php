<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public function qr()
    {
        return $this->hasMany(Qr::class, 'id_servicio')->orderBy('created_at');
    }

    
}
