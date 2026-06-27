<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'umkm_id', 'title', 'description', 'budget', 'deadline',
        'status', 'category', 'tags', 'assigned_programmer_id',
        'platform_fee', 'programmer_earning',
        'escrow_status', 'payment_method', 'project_progress',
        'github_link', 'zip_file', 'hosting_link', 'payment_date'
    ];

    protected $casts = [
        'tags' => 'array',
        'deadline' => 'date',
        'budget' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function umkm()
    {
        return $this->belongsTo(User::class, 'umkm_id');
    }

    public function programmer()
    {
        return $this->belongsTo(User::class, 'assigned_programmer_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getPlatformFeeAttribute()
    {
        return $this->budget * 0.80;
    }

    public function getProgrammerEarningAttribute()
    {
        return $this->budget * 0.20;
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu ACC',
            'open' => 'Dibuka',
            'in_progress' => 'Berjalan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }
}
