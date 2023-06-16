<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DashboardModel;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function __construct()
    {
        $this->DashModel = new DashboardModel();
    }
    public function index()
    {
        $data = [
            'dataCount' => $this->DashModel->dataCount(),
            'preprocessingCount' => $this->DashModel->preprocessingCount(),
            'labelCount' => $this->DashModel->labelCount(),
            'latihCount' => $this->DashModel->latihCount(),
            'ujiCount' => $this->DashModel->ujiCount(),
        ];
        return view('menu.dashboard', $data);
    }
}
