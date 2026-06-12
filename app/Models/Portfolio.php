<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['programmer_id', 'title', 'description', 'tags', 'project_url'];

    protected $casts = ['tags' => 'array'];

    public function programmer()
    {
        return $this->belongsTo(User::class, 'programmer_id');
    }
}
