@extends('layouts.layout')

@section('content')
<div class="container">
    <!-- Products -->
    <h2 style='padding-bottom:15px'> <strong> Your Products </strong> </h2>

    @isset($products)
        @foreach($products as $product)
            <div class="card flex-md-row mb-4 shadow-sm tab-card" style='position: relative; min-height: 50px; width:62%'>
                <img class="card-img-right flex-auto d-none d-lg-block" alt="" src="https://via.placeholder.com/180x170" >

                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary"> 
                        <a href='#' style='color:black;text-decoration:none'> {{ $product->name }} 

                        </a> 
                    </strong>

                    <p class="card-text mb-auto" style='font-size: 14px'>{{ $product->description }} </p>
                </div>

                <div style='position: absolute; bottom: 5px; left: 197px;'> 
                    <i style='font-size:14px; color:#999'> Created by: {{ $product->user_name }}</i>
                </div>

                <div style='position: absolute; bottom: 5px; left: 600px;'> 
                    <i style='font-size:14px; color:#999'> Date: {{ $product->created_at }}  </i>
                </div>
            </div>
        @endforeach
    

        <div class="row">
            <div class="col-12">
                {{$products->links()}}
            </div>
        </div>
    @endisset
</div>
    
@endsection