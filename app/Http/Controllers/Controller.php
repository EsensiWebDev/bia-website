<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function pricing()
    {
        return view('pricing');
    }
}
