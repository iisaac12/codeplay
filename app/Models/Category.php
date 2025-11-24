<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon_url'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id', 'category_id');
    }
}

