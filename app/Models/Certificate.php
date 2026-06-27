<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['programmer_id', 'name', 'issuer', 'issue_date', 'credential_url', 'certificate_file', 'status'];

    protected $casts = ['issue_date' => 'date'];

    public function programmer()
    {
        return $this->belongsTo(User::class, 'programmer_id');
    }
}
