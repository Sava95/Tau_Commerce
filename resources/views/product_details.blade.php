@extends('layouts.layout')

@section('content')

<div class='container' style='width:55%'>
    <div class='card' style='min-height: 400px'>
        <div class='card-header'> 
           <h3> <strong> {{$product->name}} </strong> </h3>
        </div>

        <div class='card-body'> 
            <div class='row' style="height: 400px;">
                <div class='col-md-9'>
                    <div name='product_description' stye='min-height: 200px'> 
                        @if(is_null($product->description))
                            <p> The product doesn't have any description </p>
                        @else 
                            {{$product->description}} 
                        @endif
                    </div> 

                    <div name='custom_url' style='margin-top:40px'> 
                        <strong style='margin-right:10px'> Product URL: </strong> {{$product->custom_url}} 
                    </div> 

                    <div name='user_name' style='margin-top:10px'> 
                        <strong style='margin-right:10px'> Created by user: </strong> {{$user->name}}
                     </div>

                     <div style='position: absolute; top:68%'> 
                        <div name='product_price' style='margin-top:50px'> 
                            <div> 
                                <strong> Price: </strong> {{$product->price}} € 
                            </div>
                        </div> 

                        <a href="{{route('edit_product', [$product->name, $product->id, $url->url])}}" class="btn btn-primary" style='position: absolute; width:75px; margin-top:20px; margin-right:10px'>Edit</a> 

                        <form style='position: absolute; left:90px' action="{{route('delete_product')}}" method='POST'>
                            @csrf
                            <input type='hidden' name='product_id' value="{{$product->id}}">
                            <button type='submit' class="btn btn-danger" style='width:75px; margin-top:20px'>Delete</button> 
                        </form>
                    </div>
                </div>

                <div class='col-md-3'>
                    <img class="card-img-right flex-auto d-none d-lg-block" alt="" src="https://via.placeholder.com/180x170" >
                </div>
            </div>
        </div>
    </div>
</div>

@endsection