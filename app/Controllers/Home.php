<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        $config['session'] = $session->get('user_detail');

        return view('index', $config);
    }
}
