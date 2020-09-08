<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleMetadata extends Model
{
    protected $fillable = ['key', 'value', 'module_id'];
}
