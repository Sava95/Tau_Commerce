@extends('layouts.layout')

@section('content')
<div class="container" style='width:65%'>
    <div class='card'> 
        <div class="card-header">
            <div style='font-size:26px; font-weight:600'> Create product </div>
        </div>

        <div class="card-body">
            <form id='create_product_form' action='' method='POST'> 
                @csrf

                <!-- product Name -->
                <div class="form-group row ">
                    <label for="product_name" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        product name: 
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="product_name" placeholder="Please enter the name of the product"
                            style="width:70%" class="form-control" autofocus required >
                    </div>
                </div>

                <!-- Custom URL -->
                <div class="form-group row">
                    <label for="custoM_url_dropDown" class="col-md-6 d-flex align-items-center" style="padding-right: 0px; font-size:20px; margin-bottom:0px">
                        Do you want to create custom url extension?
                    </label>

                    <div class="col-md-2" style="padding-right: 0px; padding-left: 0px">
                        <select class="form-control" id="sub_sector" style="width: 50%; text-align:center; appearance: auto;">
                            <option value="no" selected="selected"> no </option>
                            <option value="yes"> yes </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row ">
                    <label for="product_custom_url" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Custom URL:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="product_custom_url" placeholder="Please enter the custom URL"
                            style="width:60%" class="form-control" autofocus required >
                    </div>
                </div>

                <!-- product price -->
                <div class="form-group row ">
                    <label for="product_price" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        product price: 
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="product_price" placeholder="$"
                            style="width:10%" class="form-control" autofocus required >
                    </div>
                </div>

            </form>
        </div>
   </div>
</div>
@endsection