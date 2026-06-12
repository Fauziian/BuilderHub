<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'instructor_id', 'title', 'description', 'thumbnail', 'price',
        'level', 'category', 'is_free', 'is_published', 'total_students',
        'rating', 'total_videos', 'duration'
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function videos()
    {
        return $this->hasMany(CourseVideo::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function getLevelLabelAttribute()
    {
        return match($this->level) {
            'pemula' => 'Pemula',
            'menengah' => 'Menengah',
            'mahir' => 'Mahir',
            default => $this->level,
        };
    }

    public function getPriceFormattedAttribute()
    {
        if ($this->is_free) return 'Gratis';
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
