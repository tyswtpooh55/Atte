<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $guarded =
    [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breakings()
    {
        return $this->hasMany(Breaking::class);
    }
}
