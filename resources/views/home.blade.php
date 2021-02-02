@extends('layouts.layout')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-9 ">

        <!-- Stores -->
        <h2 style='padding-bottom:15px'> <strong> Stores </strong> </h2>
        <table class="table table-hover">
            <thead style='color: #495057; background-color: #dee2e6; border-style:hidden '>
                <tr style='height:45px'>
                    <th class="col-md-1" scope="col">ID</th>
                    <th class="col-md-3" scope="col">Store Name</th>
                    <th class="col-md-5" scope="col">Description</th>
                    <th class="col-md-3" scope="col">Date Added</th>
                </tr>
            </thead>
            <tbody>
                @isset($stores)
                    @foreach($stores as $store)
                        <tr style='height:70px'>
                            <th scope="row">{{ $store->id }}</th>
                            <td> 
                                <a href="{{route('store_products', [$store->name, $store->id])}}" style='color:black;text-decoration:none'>
                                    {{ $store->name }}
                                </a>
                            </td>
                            <td> {{ $store->description }}</td>
                            <td> {{ $store->created_at }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <!-- Products -->
        <!-- <h2 style='padding-bottom:15px'> <strong> Products </strong> </h2>

        @isset($products)
            @foreach($products as $product)
                <div class="card flex-md-row mb-4 shadow-sm tab-card" style='position: relative; min-height: 50px; width:80%'>
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
        @endisset
        
        <div class="row">
            <div class="col-12">
                @isset($products)
                    {{$products->links()}}
                @endisset   
            </div>
        </div>

    </div> -->
  


</div>
@endsection
