<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Store; 
use App\Models\Product;
use App\Models\ProductStore; 
use Illuminate\Support\Facades\Validator;

use Auth;

class MainController extends Controller
{
    // ######################## Store ################################################
    public function store()
    {
        $uniqueCode = base_convert(sha1(uniqid(mt_rand())), 16, 36);
        $store_saved = 'False';

        return view('create_store',  compact('uniqueCode', 'store_saved'));
    }

    public function create_store(Request $request)
    {
        $uniqueCode = base_convert(sha1(uniqid(mt_rand())), 16, 36);

        // Validation
        $request->validate([
            'store_name' => 'required|min:5',
            'store_code' => 'required',
            'store_custom_url' => 'required'
        ]);

        // Creating/updating Store object
        $DB_store_urls = Store::where('is_deleted', 0)->pluck('base_url')->toArray();
        $is_edit = $request->input('is_edit');

        if (isset($is_edit)){
            // Updating Store object
            $DB_store_urls_edit = array_diff($DB_store_urls, array($request->input('current_store_url')));
            
            if (in_array($request->input('store_custom_url'), $DB_store_urls_edit)) { //checking if the url already exists in the DB
                $error_message = 'The specified store URL is tacken. Please enter a new one';

                $store_id = Store::where('base_url', $request->input('current_store_url'))->where('is_deleted', 0)->pluck('id');
                $store = Store::where('id', $store_id)->where('is_deleted', 0)->get()->first();
                $is_edit = True; 
                

                return view('create_store',  compact('store', 'is_edit', 'error_message'));
            } else { 
                $store = Store::where('code', $request->input('store_code'))->where('is_deleted', 0)->first();
                $store->name = $request->input('store_name');
                $store->base_url = $request->input('store_custom_url');
                $store->description = $request->input('store_description');
                $store->save();

                $stores = Store::where('is_deleted', 0)->paginate(4);
                $products = Product::where('is_deleted', 0)->paginate(4);

                return view('home', compact('stores', 'products'));
            }
        } else {
            // Creating a new Store object
            if (in_array($request->input('store_custom_url'), $DB_store_urls)) { //checking if the url already exists in the DB
                $error_message = 'The specified store URL is tacken. Please enter a new one';

                return view('create_store',  compact('uniqueCode', 'error_message'));
            } else { 
                $new_store = new Store;
                $new_store->name = $request->input('store_name');
                $new_store->base_url = $request->input('store_custom_url');
                $new_store->code = $request->input('store_code');
                $new_store->description = $request->input('store_description');
                $new_store->is_deleted = 0;
                $new_store->save();

                $store_saved = 'True';
        
            }  

            return view('create_store',  compact('uniqueCode', 'store_saved'));;

        }
    }

    public function store_products($name, $id)
    {   
        // Checking if the user choose the unassigned products
        if ($id == 0) {
            $store_name = 'Unassigned products';

            $products_in_store = ProductStore::where('is_deleted', 0)->pluck('product_id')->toArray();
            $prducts_all = Product::where('is_deleted', 0)->pluck('id')->toArray();

            $product_ids = array_diff($prducts_all, $products_in_store);
            
            // Checking if there are multiple products that are unassigned
            if (count($product_ids) > 1){
                $products = Product::whereIn('id', $product_ids)->where('is_deleted', 0)->paginate(4);
                
            } else {
                $products = Product::where('id', $product_ids)->where('is_deleted', 0)->paginate(1);
                
            };

        } else { 
            $store_name = $name;

            $product_store = ProductStore::where('store_id', $id)->where('is_deleted', 0)->get();
            $product_store_id = ProductStore::where('store_id', $id)->where('is_deleted', 0)->pluck('product_id');
            
            // Checking to see if there are any products related to the store
            if ($product_store->isEmpty()) {
                $message = "This store doesn't have any products yet";
    
                return view('store_products', compact('message', 'store_name'));
    
            } else {
                // Checking if there are multiple products in the store 
                if (count($product_store) > 1){
                    $products = Product::whereIn('id', $product_store_id)->where('is_deleted', 0)->paginate(4);
                    
                } else {
                    $products = Product::where('id', $product_store_id)->where('is_deleted', 0)->paginate(1);
                    
                };
            }
        }
        
        return view('store_products', compact('products','store_name'));
    }

    public function edit_store($name, $id)
    {        
        $store = Store::where('id', $id)->where('is_deleted', 0)->get()->first();
        $current_store_url = $store->base_url;
        $is_edit = True; 
        
        return view('create_store', compact('store', 'is_edit', 'current_store_url'));
    }

    public function delete_store(Request $request)
    {        
        // Deleting store from DB
        $store_delete = Store::where('id', $request->store_id)->first();
        $store_delete->is_deleted = 1;
        $store_delete->save();

        // Deleting store_product relationship
        $store_product = ProductStore::where('store_id', $request->store_id)->first();
        $store_product->is_deleted = 1;
        $store_product->save();

        $stores = Store::where('is_deleted', 0)->paginate(4);
        $products = Product::where('is_deleted', 0)->paginate(4);

        return view('home', compact('stores', 'products'));
    }

   
    // ######################## Product ################################################
    public function product()
    {
        $uniqueCode = base_convert(sha1(uniqid(mt_rand())), 16, 36);
        
        $stores = Store::where('is_deleted', 0)->get();
        
        $data = [
            'uniqueCode' => $uniqueCode,
            'stores' => $stores,
        ];
        
        return view('create_product')->with($data);
    }

    public function create_product(Request $request)
    {
        $uniqueCode = base_convert(sha1(uniqid(mt_rand())), 16, 36);
        $custom_url = uniqid(mt_rand());
        $user = auth()->user();

        // Validation
        $validator = Validator::make($request->all(), [
            'prod_name' => 'required|min:5',
            'product_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else { 
            // Creating new Product object
            $new_product = new Product;

            $new_product->name = $request->input('prod_name');
            $new_product->sku = $request->input('sku');
            $new_product->price = $request->input('product_price');
            $new_product->user_id = $user->id;
            $new_product->user_name = $user->name;
            $new_product->description = $request->input('product_description');
            $new_product->is_deleted = $request->input('is_deleted');

            if ($request->input('product_custom_url') != null) {
                $new_product->custom_url = $request->input('product_custom_url');
            } else { 
                $new_product->custom_url = $custom_url;
            }

            $new_product->save();

        
            // Creating new ProductStore relation
            $stores = Store::whereIn('name', $request->input('stores'))->where('is_deleted', 0)->get();

            foreach ($stores as $store) {
                $new_product_store = new ProductStore;
                $new_product_store->product_id = $new_product->id;
                $new_product_store->store_id = $store->id;
                $new_product_store->is_deleted = 0;
                $new_product_store->save();
            }
            

            return response()->json($uniqueCode);
        }
        
    }

    public function user_profile()
    {
        $products = Product::where('user_id', Auth::user()->id)->where('is_deleted', 0)->paginate(4);
        
        return view('your_ads', compact('products'));
    }

}