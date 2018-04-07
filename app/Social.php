<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $table = 'social_acc';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
