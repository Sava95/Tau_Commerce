<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Store; 
use App\Models\Product;
use App\Models\ProductStore; 
use App\Models\User; 
use App\Models\Url; 
use Illuminate\Support\Facades\Validator;

use Auth;

class StoreController extends Controller
{
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
                $products = Product::paginate(4);

                $success_message = 'Changes saved';
                
                return view('home', compact('stores', 'products', 'success_message'));
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
            $prducts_all = Product::where('id','>', 0)->pluck('id')->toArray();

            $product_ids = array_diff($prducts_all, $products_in_store);
            
            // Checking to see if there are any products related to the store
            if ($product_ids == '[]') {
                $message = "This store doesn't have any products yet";
    
                return view('store_products', compact('message', 'store_name'));
    
            } else {
                // Checking if there are multiple products that are unassigned
                if (count($product_ids) > 1){
                    $products = Product::whereIn('id', $product_ids)->paginate(4);
                    $urls = Url::whereIn('urlable_id', $product_ids )->pluck('url')->toArray();

                } else {
                    $products = Product::where('id', $product_ids)->paginate(1);
                    $urls = Url::where('urlable_id', $product_ids )->pluck('url')->toArray();
                };
            }
            return view('store_products', compact('products','store_name','urls'));

        } else { 
            $store_name = $name;

            $product_store = ProductStore::where('store_id', $id)->where('is_deleted', 0)->get();
            $product_store_id = ProductStore::where('store_id', $id)->where('is_deleted', 0)->pluck('product_id');
            
            // Checking to see if there are any products related to the store
            if (count($product_store) < 1) {
                $message = "This store doesn't have any products yet";
    
                return view('store_products', compact('message', 'store_name'));
    
            } else {
                // Checking if there are multiple products in the store 
                if (count($product_store) > 1){
                    $products = Product::whereIn('id', $product_store_id)->paginate(4);
                    $urls = Url::whereIn('urlable_id', $product_store_id )->pluck('url')->toArray();
                    
                } else {
                    $products = Product::where('id', $product_store_id)->paginate(1);
                    $urls = Url::where('urlable_id', $product_store_id )->pluck('url')->toArray();
                    
                };
            }

            $store = Store::find($id)->where('is_deleted', 0)->get()->first();

            return view('store_products', compact('products','store_name','urls', 'store'));
        }

        
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
        if (!is_null($store_product)) {
            $store_product->is_deleted = 1;
            $store_product->save();
        }
        
        $stores = Store::where('is_deleted', 0)->paginate(4);
        $products = Product::paginate(4);

        $delete_message = 'Store has been deleted';

        return view('home', compact('stores', 'products', 'delete_message'));
    }

    
    
}