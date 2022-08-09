<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // U slucaju da sam napravio migraciju za messages u jednini  resenje je $table
    //protected $table = 'message';


    public function ad()
    {

        return $this->belongsTo('\App\Models\Ad');
    }

    public function sender()
    {
        return $this->belongsTo('\App\Models\User', 'sender_id');
    }
}
