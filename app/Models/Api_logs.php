<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api_logs extends Model
{
    protected $fillable = [
        'endpoint',
        'method',
        'duration',
        'type',
        'user_id'
    ];




    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
