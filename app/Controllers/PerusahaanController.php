<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PerusahaanController extends BaseController
{
    public function index()
    {
        return view('perusahaan/form');
    }
}
