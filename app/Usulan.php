<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usulan extends Model
{
    protected $casts = [
        'loading_verif' => 'boolean',
        'loading_valid' => 'boolean',
        'loading_prioritas' => 'boolean',
    ];
}
