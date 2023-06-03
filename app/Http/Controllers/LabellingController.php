<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LabellingController extends Controller
{
    public function index()
    {
        return view('menu.labelling');
    }
}
