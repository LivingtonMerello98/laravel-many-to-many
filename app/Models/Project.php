<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'image', 'title', 'description', 'category_id', 'slug'
    ];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }
}





    // public function getLanguagesArrayAttribute()
    // {
    //     return explode(',', $this->languages);
    // }

    // public function setLanguagesArrayAttribute($value)
    // {
    //     $this->attributes['languages'] = implode(',', $value);
    // }