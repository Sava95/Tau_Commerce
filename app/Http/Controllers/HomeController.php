<?php

namespace App\Http\Controllers;
use Auth;

use Illuminate\Http\Request;
use App\Models\Store; 
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stores = Store::where('is_deleted', 0)->paginate(4);
        $products = Product::paginate(4);

        return view('home', compact('stores', 'products'));
    }

    public function user_profile()
    {
        $products = Product::where('user_id', Auth::user()->id)->paginate(6);
        
        return view('your_ads', compact('products'));
    }
}
