<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DashboardModel extends Model
{
    public function dataCount()
    {
        return DB::table('data_raw')->count();
    }
    public function preprocessingCount()
    {
        return DB::table('data_preprocessing')->count();
    }
    public function labelCount()
    {
        return DB::table('data_preprocessing')->whereNotNull('sentiment_label')->count();
    }
    public function latihCount()
    {
        return DB::table('data_training')->count();
    }
    public function ujiCount()
    {
        return DB::table('data_testing')->count();
    }
}
