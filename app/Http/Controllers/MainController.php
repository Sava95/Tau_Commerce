<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth;

class MainController extends Controller
{
    public function store()
    {
        return view('create_store');
    }

    public function product()
    {
        return view('create_product');
    }

}