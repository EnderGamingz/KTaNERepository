<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleLink extends Model
{
    protected $fillable = ['module_id', 'link', 'name']
}
