<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * @var array For all types which should be handled differently
     */
    protected $casts = [
        'credits' => 'array'
    ];

    /**
     * @return QueryBuilder for the active maintainers of this module
     */
    public function maintainer()
    {
        return $this->belongsTo(User::class, 'module_maintainer');
    }

    /**
     * @return QueryBuilder for the tags of this module
     */
    public function tags()
    {
        return $this->belongsTo(Tag::class, 'module_tag');
    }

    /**
     * @return QueryBuilder for all links of this module
     */
    public function links()
    {
        return $this->hasMany(ModuleLink::class);
    }

    /**
     * @return QueryBuilder for all module capabilities
     */
    public function capabilities()
    {
        return $this->hasMany(ModuleCapabilities::class);
    }

    /**
     * @return QueryBuilder for all module metadata entries
     */
    public function metadata()
    {
        return $this->hasMany(ModuleMetadata::class);
    }

    /**
     * @return QueryBuilder for all module issues
     */
    public function issues()
    {
        return $this->hasMany(ModuleIssue::class);
    }

    /**
     * @return QueryBuilder for all manuals
     */
    public function manuals()
    {
        return $this->hasMany(ModuleManual::class);
    }
}
