<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'project_id',
        'course_id',
        'reviewer_id',
        'reviewed_id',
        'rating',
        'comment',
        'type', // 'umkm' | 'course'
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get star HTML display
     */
    public function getStarsHtmlAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '⭐' : '☆';
        }
        return $stars;
    }
}
