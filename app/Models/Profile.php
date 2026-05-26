<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Attachment;

class Profile extends Model
{
    
    protected $fillable=[
        'address',
        'phone',
    ];
    


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
