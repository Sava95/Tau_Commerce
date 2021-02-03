@extends('layouts.layout')

@section('content')
<div class="container" style='width:65%'>

    <!-- Success Message -->
    @isset($store_saved)
        @if($store_saved == 'True')
            <div class="alert alert-success" role="alert">
                Store has been saved! 
            </div>
        @endif
    @endisset

    <!-- Error Message -->
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
        @endforeach
    @endif

    @isset($error_message)
        <div class="alert alert-danger" role="alert">
            {{$error_message}}
        </div>
    @endisset

    <div class='card'> 
        <div class="card-header">
            <div style='font-size:26px; font-weight:600'> Create Store </div>
        </div>

        <div class="card-body" style="max-height:350px">
            <form id='create_store_form' action="{{route('create_store')}}" method='POST'> 
                @csrf

                <!-- Store Name -->
                <div class="form-group row ">
                    <label for="store_name" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Store name: 
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="store_name" name="store_name" placeholder="Please enter the name of the store"
                            style="width:60%" class="form-control" autofocus required @isset($store) value='{{$store->name}}'  @endisset> 
                    </div>
                </div>

                <!-- Base URL -->
                <div class="form-group row ">
                    <label for="store_custom_url" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Store URL:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <input type="text" id="store_custom_url" name="store_custom_url" placeholder="Please enter the custom URL"
                            style="width:30%" class="form-control" required @isset($store) value='{{$store->base_url}}' @endisset > 
                    </div>
                </div>

                @isset($current_store_url)
                    <input type='hidden' name='current_store_url' value='{{$current_store_url}}'>
                @endisset

                <!-- Store Code -->
                <input type='hidden' name="store_code" @if(isset($store)) value='{{$store->code}}' @else value="{{$uniqueCode}}" @endif > 

                <!-- Description  -->
                <div class="form-group row">
                    <label for="store_description" class="col-md-2" style="padding-right: 0px; margin-top:3px; font-size:20px">
                        Description:
                    </label>

                    <div class="col-md-10" style="padding-right: 0px">
                        <textarea id="store_description" name="store_description" class='form-control' style="height:100px; width: 90%">@isset($store) {{$store->description}}  @endisset</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class='d-flex justify-content-left'>
                    <button type='submit' style='margin-top:40px; padding: 8px; font-size:17px; width:10%;'
                            class="btn btn-lg btn-primary"> Save  </button>
                </div>

                <!-- Checking if edit or update -->
                @isset($is_edit)
                    <input type='hidden' name='is_edit' value ='{{$is_edit}}'> 
                @endisset
            </form>

            <!-- Delete Form -->
            @isset($store)
                <form id='delete_store_form' style='position: relative; top:-83px; left:120px' action="{{route('delete_store')}}" method='POST'>
                    @csrf
                    <input type='hidden' name='store_id' value='{{$store->id}}'>

                    <button type='submit' style='margin-top:40px; padding: 8px; font-size:17px; width:10%;'
                            class="btn btn-lg btn-danger"> Delete </button>
                </form>

            @endisset
        </div>
   </div>
</div>
@endsection