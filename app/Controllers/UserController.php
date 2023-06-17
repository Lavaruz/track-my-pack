<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        return view('user/form');
    }

    public function profile()
    {
        # code...
    }

    public function addForm()
    {
        print_r('MASUK ADD FORM NYA USER');die();
    }
}
