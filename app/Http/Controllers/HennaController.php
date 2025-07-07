<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HennaController extends Controller
{
    public function group()
    {
        return view('henna.group');
    }

    public function individual()
    {
        return view('henna.individual');
    }
}
