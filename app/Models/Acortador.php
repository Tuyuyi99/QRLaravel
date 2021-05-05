<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acortador extends Model
{

    public $table = "acortadores";

    use HasFactory;

    protected $fillable = [
        'codigo', 'link', 'id_qr'
    ];

    public function qr() {
        return $this->belongsTo(Qr::class, 'id_acortador');
    }
}
