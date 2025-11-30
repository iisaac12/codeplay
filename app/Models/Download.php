<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'downloads';
    protected $primaryKey = 'download_id';
    
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'material_id'
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id', 'material_id');
    }
}

