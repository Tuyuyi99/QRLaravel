<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    use HasFactory;

    
    public function acortador() {
        return $this->hasMany(Acortador::class, 'id_qr');
    }
}
