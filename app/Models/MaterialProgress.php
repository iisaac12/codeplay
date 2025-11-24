<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialProgress extends Model
{
    protected $table = 'material_progress';
    protected $primaryKey = 'progress_id';
    
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'material_id',
        'is_completed',
        'completed_at',
        'last_position'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id', 'material_id');
    }
}