@extends('layouts.layout')

@section('content')
<div class="container" style='width:65%'>
    <!-- Error Message -->
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach
    @endif

    <div class='card'> 
        <div class="card-header">
            <div style='font-size:26px; font-weight:600'> Create Store </div>
        </div>

        <div class="card-body">
            <form id='create_store_form' action="{{route('create_store')}}" method='POST'> 
                @csrf

                <!-- Store Name -->
                <div class="form-group row ">
                    <label for="store_name" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Store name: 
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="store_name" name="store_name" placeholder="Please enter the name of the store"
                            style="width:60%" class="form-control" autofocus required >
                    </div>
                </div>

                <!-- Base URL -->
                <div class="form-group row ">
                    <label for="store_custom_url" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Store URL:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="store_custom_url" name="store_custom_url" placeholder="Please enter the custom URL"
                            style="width:30%" class="form-control" required >
                    </div>
                </div>

                <!-- Store Code -->
                <input type='hidden' name="store_code" value="{{$uniqueCode}}"> 

                <!-- Description  -->
                <div class="form-group row">
                    <label for="store_description" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Description:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <textarea id="store_description" name="store_description" class='form-control' style="height:100px; width: 90%"></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class='d-flex justify-content-left'>
                    <button type='submit' style='margin-top:40px; padding: 8px; font-size:17px; width:26%;'
                            class="btn btn-lg btn-primary"> Create Store </button>
                </div>
            </form>
        </div>
   </div>
</div>
@endsection