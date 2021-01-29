<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth;

class MainController extends Controller
{
    public function store()
    {
        $uniqueCode = base_convert(sha1(uniqid(mt_rand())), 16, 36);

        return view('create_store',  compact('uniqueCode'));
    }

    public function product()
    {
        return view('create_product');
    }

}