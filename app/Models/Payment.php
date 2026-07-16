<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [

        'user_id',
        'borrowing_id',
        'jumlah',
        'bukti',
        'status',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

}