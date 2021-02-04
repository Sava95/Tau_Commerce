@extends('layouts.layout')

@section('content')
<div class="container">
    <!-- Success Message -->
    @isset($success_message)
        <div id="home_success_message" class="alert alert-success" role="alert" style="position:fixed; z-index: 1; margin-left:110px; width:64.2%"> 
            {{$success_message}}
        </div>
    @endisset

    @isset($delete_message)
        <div id="home_success_message" class="alert alert-danger" role="alert" style="position:fixed; z-index: 1; margin-left:110px; width:64.2%">  
            {{$delete_message}}
        </div>
    @endisset

  <div class="row d-flex justify-content-center">
    <div class="col-10"> 
        <!-- Stores -->
        @isset($stores)
            <h2 style='padding-bottom:15px'> <strong> Stores </strong> </h2>
            <table class="table table-hover">
                <thead style='color: #495057; background-color: #dee2e6; border-style:hidden '>
                    <tr style='height:45px'>
                        <th class="col-md-1" scope="col">ID</th>
                        <th class="col-md-2" scope="col">Store Name</th>
                        <th class="col-md-5" scope="col">Description</th>
                        <th class="col-md-3" scope="col">Date Added</th>
                        <th class="col-md-1" scope="col"></th>
                    </tr>
                </thead>
                
                <tbody>
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
                                <td class='align-middle'> 
                                    <a href="{{route('edit_store', [$store->name, $store->id])}}" class="btn btn-primary" style='width:75px'>Edit</a> 
                                </td>
                            </tr>
                        @endforeach
                
                </tbody>
            </table> 

            <div class="row">
                <div class="col-12">
                    {{$stores->links()}}
                </div>
            </div>
        @endisset
    </div>
  </div>

  <div class="row" style='margin-left:100px'>
    <!-- Products that weren't assigned a shop  -->
    <div style='width:26%; padding-right:0px'> <label> Products that weren't assigned to a shop: </label>  </div>
    <div style='width:20%; padding-left: 0px'>  <a href="{{route('store_products', ['Unassigned', '0'])}}"> Unassigned products</a> </div>
  </div>
 
</div>

@endsection
