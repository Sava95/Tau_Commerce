@extends('layouts.layout')

@section('content')

<div class="container">
    <!-- Products -->
    <h2 style='padding-bottom:15px'> <strong> Your Products </strong> </h2>
    
    @foreach ($products as $product)
        {{$product}}
    @endforeach

    <div> 
    {{$count}}

    </div>

    <div> 
    {{$product_store_id}}

    </div>

    
    <div> 
    {{$type_1}}
    {{$type_2}}
    </div>



    
    
</div>

@endsection