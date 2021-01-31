<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Store; 

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

    public function create_store(Request $request)
    {
        $new_store = new Store;

        $new_store->name = $request->input('store_name');
        $new_store->code = $request->input('store_code');
        $new_store->base_url = $request->input('store_custom_url');
        $new_store->description = $request->input('store_description');
        $new_store->is_deleted = 0;
        $new_store->save();

        return view('create_store');
    }
}