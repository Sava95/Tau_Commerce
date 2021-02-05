<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Store; 
use App\Models\Product;
use App\Models\ProductStore; 
use App\Models\User; 
use App\Models\Url; 
use Illuminate\Support\Facades\Validator;
use Redirect;

class ProductController extends Controller
{
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

        
        $validator = Validator::make($request->all(), [
            'prod_name' => 'required|min:5',
            'product_price' => 'required|numeric',
            // 'url' => 'unique:urls,url'
        ]);
        
        // Getting the urls that are assosiated to the selected store/stores
        if ($request->input('store_names') != 'Nothing selected') {
            if (is_array($request->input('store_names'))) {
                $stores = Store::whereIn('name', $request->input('store_names'))->where('is_deleted', 0)->get();
                $store_ids = Store::whereIn('name', $request->input('store_names'))->pluck('id')->toArray();
                $product_ids = ProductStore::whereIn('store_id', $store_ids)->pluck('product_id')->toArray();
                $urls = Url::whereIn('urlable_id', $product_ids)->where('urlable_type','App\Models\Product')->pluck('url')->toArray();
    
            } else {
                $stores = Store::where('name', $request->input('store_names'))->where('is_deleted', 0)->get();
                $store_ids = Store::where('name', $request->input('store_names'))->pluck('id')->toArray();
                $product_ids = ProductStore::where('store_id', $store_ids)->pluck('product_id')->toArray();
                $urls = Url::where('urlable_id', $product_ids)->where('urlable_type','App\Models\Product')->pluck('url')->toArray();
            }
        } else { 
            $urls = Url::get();
        }

        // Validation
        if ($validator->fails()) {

            return response()->json($validator->errors());
        } else { 
            // Validation 2 - URL
            if (in_array($request->input('product_custom_url'), $urls )) { //checking if the url already exists in the DB
                
                $uniqueCode = base_convert(sha1(uniqid(mt_rand())), 16, 36);
                $error_message = True;

                return response()->json([$uniqueCode, $error_message]);
            } else {
                // // Creating new Product object
                $new_product = new Product;

                $new_product->name = $request->input('prod_name');
                $new_product->sku = $request->input('sku');
                $new_product->price = $request->input('product_price');
                $new_product->user_id = $user->id;
                $new_product->user_name = $user->name;
                $new_product->description = $request->input('product_description');
                
                $new_product->save();

            
                // Creating new ProductStore relation
                foreach ($stores as $store) {
                    $new_product_store = new ProductStore;
                    $new_product_store->product_id = $new_product->id;
                    $new_product_store->store_id = $store->id;
                    $new_product_store->is_deleted = 0;
                    $new_product_store->save();
                };

                // Saving the url in the URL model 
                $new_url = new Url;

                if ($request->input('product_custom_url') != null) {
                    $new_url->url = $request->input('product_custom_url');
                } else { 
                    $new_url->url = $custom_url;
                }

                $new_url->urlable_id = $new_product->id;
                $new_url->urlable_type = "App\Models\Product";
                $new_url->save();

                return response()->json($uniqueCode);
            }
        }

    }

    public function product_details($store_name, $store_id, $product_name, $product_id, $custom_url)
    {        
       $product = Product::find($product_id);
       $user = User::find($product->user_id);
       $url = Url::where('urlable_id', $product_id )->get()->first();

        return view('product_details', compact('product', 'user','url', 'store_id'));
    }

    public function unassigned_product_details($product_name, $product_id, $custom_url)
    {        
       $product = Product::find($product_id);
       $user = User::find($product->user_id);
       $url = Url::where('urlable_id', $product_id )->get()->first();

        return view('product_details', compact('product', 'user', 'url'));
    }

    public function delete_product(Request $request)
    {        

        // Deleting store_product relationship
        $store_product = ProductStore::where('product_id', $request->product_id)->first();
        if (!is_null($store_product)) {
            $store_product->is_deleted = 1;
            $store_product->save();
        }
        
        $stores = Store::where('is_deleted', 0)->paginate(4);
        $products = Product::paginate(4);

        $delete_message = 'Product has been deleted';

        return view('home', compact('stores', 'products', 'delete_message'));
    }

    public function edit_product($product_name, $product_id, $custom_url, $store_id)
    {        
        $product = Product::find($product_id);  
        $stores = Store::where('is_deleted', 0)->get();

        $product_store = ProductStore::where('product_id', $product_id)->where('is_deleted', 0)->get()->first();  
        $url = Url::where('urlable_id', $product_id)->get()->first();
        $uniqueCode = $product->sku;

        $is_edit = True; 
        
        return view('create_product', compact('stores', 'store_id', 'uniqueCode', 'is_edit', 'url', 'product', 'product_store'));
    }

    public function save_edit_product(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|min:5',
            'product_price' => 'required|numeric',
            // 'url' => 'unique:urls,url'
        ]);

        if ($validator->fails()) {
            
            return Redirect::back()->withErrors($validator->errors());
        } else { 
            // Validation - URL
            $product_ids = ProductStore::where('store_id', $request->input('store_id'))->pluck('product_id')->toArray();

            if (is_array($product_ids)) {
                $urls = Url::whereIn('urlable_id', $product_ids)->where('urlable_type','App\Models\Product')->pluck('url')->toArray();
            } else {
                $urls = Url::where('urlable_id', $product_ids)->where('urlable_type','App\Models\Product')->pluck('url')->toArray();
            }
                
            $urls_diff = array_diff($urls, array($request->input('current_store_url'))); // all the urls except the current one
            
            if (in_array($request->input('product_custom_url'), $urls_diff)) { //checking if the url already exists in the DB
                $error_message = 'The selected URL already exist in the database. Please select a new one.';

                return Redirect::back()->withErrors($error_message);
            } else {
                // Updating product 
                $product = Product::where('sku', $request->sku)->get()->first();
                $product->name = $request->input('product_name');
                $product->price = $request->input('product_price');
                $product->description = $request->input('product_description');
                $product->save();

                // Updating url
                $url = Url::where('urlable_id', $product->id)->get()->first();
                $url->url = $request->input('product_custom_url');
                $url->save();

                $success_message = "Product has been successfully updated.";
            };
        };
        
        $stores = Store::where('is_deleted', 0)->paginate(4);
        $products = Product::paginate(4);

        return view('home', compact('stores', 'products', 'success_message'));
        
    }

}
