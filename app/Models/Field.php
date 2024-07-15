<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\Models\User');
    }

    protected $fillable = [
        'name', 'number'
    ];
    use HasFactory;
}
