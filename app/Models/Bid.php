<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['project_id', 'programmer_id', 'amount', 'message', 'timeline_days', 'status', 'rejection_count', 'is_revised', 'is_seen_by_umkm'];

    protected $casts = ['is_seen_by_umkm' => 'boolean', 'is_revised' => 'boolean'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function programmer()
    {
        return $this->belongsTo(User::class, 'programmer_id');
    }
}
