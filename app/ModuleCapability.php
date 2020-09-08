<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleCapability extends Model
{
    protected $fillable = ['module_id', 'name', 'data'];

    protected $casts = [
        'data' => 'array'
    ];
}
