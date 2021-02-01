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

    {{$stores->first()->name}}

    @foreach ($stores as $store)
        {{$store->name}}
    @endforeach

    <!-- Card Form -->
    <div class='card'> 
        <div class="card-header">
            <div style='font-size:26px; font-weight:600'> Create product {{$uniqueCode}} </div>
        </div>
       
        <div class="card-body">
            <form id='create_product_form'> 
                @csrf

                <!-- Product Name -->
                <div class="form-group row ">
                    <label for="product_name" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Product name: 
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="product_name" name='product_name' placeholder="Please enter the name of the product"
                            style="width:70%" class="form-control" autofocus required >
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
                            <option value="no" selected="selected"> no </option>
                            <option value="yes"> yes </option>
                        </select>
                    </div>
                </div>

                <div id='custom_url' style='display:none'> 
                    <div class="form-group row ">
                        <label for="product_custom_url" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                            Custom URL:
                        </label>

                        <div class="col-md-10" style="padding-right: 0px">
                            <input type="text" id="product_custom_url" placeholder="Please enter the custom URL"
                                style="width:60%" class="form-control" >
                        </div>
                    </div>
                </div>

                <!-- Select Store -->
                <div class="form-group row">
                    <label for="custom_url_dropDown" class="col-md-6 d-flex align-items-center" style="padding-right: 0px; font-size:20px; margin-bottom:0px">
                        Do you want to create custom url extension?
                    </label>

                    <div class="col-md-5" style="padding-right: 0px; padding-left: 0px">
                        <select class="form-control" id="custom_url_dropDown" style="width: 50%; text-align:center; appearance: auto;">
                            @foreach ($stores as $store)
                                <option value="no" selected="selected"> A </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Product Price -->
                <div class="form-group row ">
                    <label for="product_price" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Product price: 
                    </label>

                    <div class="col-md-1" style="padding-right: 0px">
                        <input type="text" id="product_price" placeholder="€" class="form-control" autofocus required >
                    </div>

                    <label for='product_price' class='col-md-2 col-form-label '> € </label>
                </div>

                <!-- Description  -->
                <div class="form-group row">
                    <label for="product_description" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Description:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <textarea id="product_description" name="product_description" class='form-control' style="height:100px; width: 90%"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class='d-flex justify-content-left'>
                        <button id='submit_product' type='submit' style='margin-top:40px; padding: 8px; font-size:17px; width:26%;'
                                class="btn btn-lg btn-primary"> Create Product </button>
                </div>
            </form>
        </div>
   </div>
</div>
@endsection