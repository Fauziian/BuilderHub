<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'city', 'bio', 'avatar',
        'is_verified', 'is_top_programmer', 'rating', 'course_rating', 'total_projects', 'total_earnings',
        'business_name', 'business_type', 'legal_doc', 'umkm_verified', 'expertise',
        'ktp_number', 'ktp_photo', 'business_photo', 'cv_file', 'portfolio_file'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
        'is_top_programmer' => 'boolean',
        'umkm_verified' => 'boolean',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'umkm_id');
    }

    public function assignedProjects()
    {
        return $this->hasMany(Project::class, 'assigned_programmer_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'programmer_id');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'programmer_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'programmer_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function getAvatarInitialAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProgrammer(): bool
    {
        return $this->role === 'programmer';
    }

    public function isUMKM(): bool
    {
        return $this->role === 'umkm';
    }

    public function isCourse(): bool
    {
        return $this->role === 'course';
    }

    public static function recalcRatings(int $userId): void
    {
        $umkmAvg = \App\Models\Review::where('reviewed_id', $userId)
            ->where('type', 'umkm')
            ->avg('rating') ?? 0;

        $courseAvg = \App\Models\Review::where('reviewed_id', $userId)
            ->where('type', 'course')
            ->avg('rating') ?? 0;

        self::where('id', $userId)->update([
            'rating' => round($umkmAvg, 2),
            'course_rating' => round($courseAvg, 2),
        ]);
    }
}
