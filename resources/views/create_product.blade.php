@extends('layouts.layout')

@section('content')
<div class="container" style='width:65%'>
    <!-- Success Message -->
    <div id="success_message" class="alert alert-success" role="alert" style=" display:none; position:fixed; z-index: 1; margin-top:10px;
        width: 63.5%"> <b> Success! </b> You have successfully added a product!
    </div>

    <!-- Error Messages -->
    <div id="error_message_prod_name" class="alert alert-danger" role="alert" style="display:none; position:fixed; z-index: 1; margin-top:10px;
        width: 63.5%"> 
    </div>

    <div id="error_message_prod_price" class="alert alert-danger" role="alert" style="display:none; position:fixed; z-index: 1; margin-top:10px; 
        width: 63.5%"> 
    </div>

    <div id="error_message_url" class="alert alert-danger" role="alert" style="display:none; position:fixed; z-index: 1; margin-top:10px; 
        width: 63.5%"> 
    </div>

    <!-- Edit Product Page Error Message -->
    @if($errors->any())
        <div id="error_url" class="alert alert-danger" role="alert" style="position:fixed; z-index: 1; margin-top:10px; 
        width: 63.5%">  {{$errors->first()}}
        </div>
    @endif

    <!-- Card Form -->
    <div class='card'> 
        <div class="card-header">
            <div style='font-size:26px; font-weight:600'> Create product </div>
        </div>
       
        <div class="card-body">
            <form id='create_product_form' @isset($is_edit) action="{{route('save_edit_product')}}" method='POST'  @endisset> 
                @csrf
                
                <!-- Product Name -->
                <div class="form-group row ">
                    <label for="product_name" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Product name: 
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="product_name" name='product_name' placeholder="Please enter the name of the product"
                               style="width:70%" class="form-control" autofocus required @isset($product) value='{{$product->name}}' @endisset >
                    </div>
                </div>

                <!-- SKU Code -->
                <input id='sku' name="sku" type='hidden' value="{{$uniqueCode}}"> 

                <!-- Custom URL -->
                <div class="form-group row">
                    <label for="custom_url_dropDown" class="col-md-6 d-flex align-items-center" style="padding-right: 0px; font-size:20px; margin-bottom:0px">
                        Do you want to create custom url extension?
                    </label>

                    <div class="col-md-2" style="padding-right: 0px; padding-left: 0px">
                        <select class="form-control" id="custom_url_dropDown" style="width: 50%; text-align:center; appearance: auto;">
                            @if(isset($url))
                                <option value="no" > No </option>
                                <option value="yes" selected="selected"> Yes </option>
                            @else
                                <option value="no" selected="selected"> No </option>
                                <option value="yes"> Yes </option>
                            @endif
                        </select>
                    </div>
                </div>

                <div id='custom_url' style='display:none'> 
                    <div class="form-group row ">
                        <label for="product_custom_url" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                            Custom URL:
                        </label>

                        <div class="col-md-10" style="padding-right: 0px">
                            <input type="text" id="product_custom_url" name='product_custom_url' placeholder="Please enter the custom URL"
                                style="width:60%" class="form-control" @isset($url) value='{{$url->url}}' @endisset >
                        </div>
                    </div>
                </div>

                <!-- Current Product URL -->
                @if(isset($url))
                    <input type='hidden' name='current_store_url' value='{{$url->url}}'>
                @endif

                <!-- Select Store -->
                @if(!isset($product_store))
                    <div class="form-group row">
                        <label for="store_dropDown" class="col-md-6 d-flex align-items-center" style="padding-right: 0px; font-size:20px; margin-bottom:0px">
                            Do you want to put the product in a store?
                        </label>

                        <div class="col-md-2" style="padding-right: 0px; padding-left: 0px">
                            <select class="form-control" id="store_dropDown" style="width: 50%; text-align:center; appearance: auto;">
                                <option value="no" selected="selected"> No </option>
                                <option value="yes" > Yes </option>
                            </select>
                        </div>
                    </div>

                
                    <div id='store' style='display:none'> 
                        <div class="form-group row ">
                            <label for="store_select" class="col-md-1" style="padding-right: 0px; margin-top:3px; font-size:20px">
                                Store:
                            </label>
                            <div class="col-md-5" style="padding-right: 0px; padding-left: 0px">
                                <select id="store_select" class='selectpicker' multiple style="width: 50%; text-align:center; appearance: auto;">
                                    @foreach ($stores as $store)
                                        <option value='{{$store->id}}'> {{$store->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                                
                        </div>
                    </div>

                @endif

                @if(isset($store_id))
                    <!-- Store  -->
                    <input type='hidden' name='store_id' value='{{$store_id}}' >
                @endif

                <!-- Product Price -->
                <div class="form-group row ">
                    <label for="product_price" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Product price: 
                    </label>

                    <div class="col-md-1" style="padding-right: 0px">
                        <input type="text" id="product_price" name="product_price" placeholder="€" class="form-control" @isset($product) value='{{$product->price}}' @endisset  required >
                    </div>

                    <label for='product_price' class='col-md-2 col-form-label '> € </label>
                </div>

                <!-- Description  -->
                <div class="form-group row">
                    <label for="product_description" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Description:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <textarea id="product_description" name="product_description" class='form-control' style="height:100px; width: 90%">@isset($product) {{$product->description}} @endisset</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class='d-flex justify-content-left'>
                        <button id='submit_product' type='submit' style='margin-top:40px; padding: 8px; font-size:17px; width:10%;'
                                class="btn btn-lg btn-primary"> Save </button>
                </div>
            </form>
        </div>
   </div>
</div>
@endsection