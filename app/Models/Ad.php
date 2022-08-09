<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $guarded = [];


    // Zelim da vidim categoriju kojoj pripada sam ovaj oglas
    public function category()
    {

        return $this->belongsTo('\App\Models\Category');
    }


    //  zelim da saznam vlasnika odredjenog oglasa
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}
