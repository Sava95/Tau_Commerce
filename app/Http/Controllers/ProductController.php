<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Store; 
use App\Models\Product;
use App\Models\ProductStore; 
use App\Models\User; 
use App\Models\Url; 
use Illuminate\Support\Facades\Validator;

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
            
            $new_product->save();

        
            // Creating new ProductStore relation
            $stores = Store::whereIn('name', $request->input('stores'))->where('is_deleted', 0)->get();

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

    public function product_details($store_name, $store_id, $product_name, $product_id, $custom_url)
    {        
       $product = Product::find($product_id);
       $user = User::find($product->user_id);

        return view('product_details', compact('product', 'user'));
    }

    public function unassigned_product_details($product_name, $product_id, $custom_url)
    {        
       $product = Product::find($product_id);
       $user = User::find($product->user_id);

        return view('product_details', compact('product', 'user'));
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

    public function edit_product($product_name, $product_id, $custom_url)
    {        
        $product = Product::where('id', $product_id)->get()->first();  
        $stores = Store::where('is_deleted', 0)->get();

        $product_store = ProductStore::where('product_id', $product_id)->where('is_deleted', 0)->get()->first();  
        $uniqueCode = $product->code;
        
        $is_edit = True; 
        
        return view('create_product', compact('stores', 'uniqueCode', 'is_edit', 'product', 'product_store'));
    }

}
