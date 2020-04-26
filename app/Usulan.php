<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    protected $casts = [
        'loading_verifikasi' => 'boolean',
        'loading_validasi' => 'boolean',
        'loading_prioritas' => 'boolean',
    ];
}
