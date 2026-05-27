<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberRequest extends Model
{
    protected $fillable = [

        'user_id',
        'status',

    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}