@extends('layouts.layout')

@section('content')

<div class="container">
    <!-- Products -->
    <h2 style='padding-bottom:15px'> <strong> {{$store_name}} </strong> </h2>

    @isset($message)
        <h4> {{$message}} </h4>
    @endisset

    <?php $index = 0 ?>

    @isset($products)
        @foreach($products as $product)
            <div class="card flex-md-row mb-4 shadow-sm tab-card" style='position: relative; min-height: 50px; width:62%'>
                <img class="card-img-right flex-auto d-none d-lg-block" alt="" src="https://via.placeholder.com/180x170" >

                <div class="card-body d-flex flex-column align-items-start" style='margin-bottom:20px'>
                    <strong class="d-inline-block mb-2 text-primary"> 
                        @if(isset($store))
                            <a href="{{route('product_details', [$store->name, $store->id, $product->name, $product->id, $urls[$index]])}}" style='color:black;text-decoration:none'> {{ $product->name }} 
                            </a>
                        @else 
                            <a href="#" style='color:black;text-decoration:none'> {{ $product->name }} 
                            </a>
                        @endif
                    </strong>

                    <?php 
                        $index = $index + 1;
                        if (!is_null($product->description)) {
                            if (strlen($product->description) > 250) {
                                $description_short = substr($product->description, 0, -(strlen($product->description)-250));
                                $description_short .= '...';
                            }  else {
                                $description_short = $product->description;
                            }
                        } else { 
                            $description_short = null; 
                        }
                    ?>

                    <p class="card-text mb-auto" style='font-size: 14px; max-height:200px'> {{$description_short}} </p>
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