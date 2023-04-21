<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        $config['user_detail'] = $session->get('user_detail');
        
        return view('index', $config);
    }
}
