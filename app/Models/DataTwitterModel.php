<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTwitterModel extends Model
{
    protected $table = 'data_twitter';
    // protected $primarykey = 'id_tweet';
    public $timestamps = false;
    protected $fillable = [
        // 'id_tweet',
        'user',
        'created_at',
        'real_text',
    ];
}
