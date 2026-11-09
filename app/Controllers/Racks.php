<?php

namespace App\Controllers;

class Racks extends BaseController
{
    public function index(): string
    {
        return view('racks/index', [
            'title' => 'Data Rak - SIPUS',
        ]);
    }
}
