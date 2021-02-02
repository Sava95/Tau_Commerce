@extends('layouts.layout')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8 ">

        <!-- Stores -->
        <h2 style='padding-bottom:15px'> <strong> Stores </strong> </h2>
        <table class="table table-hover">
            <thead style='color: #495057; background-color: #dee2e6; border-style:hidden '>
                <tr>
                    <th class="col-md-1" scope="col">ID</th>
                    <th class="col-md-3" scope="col">Store Name</th>
                    <th class="col-md-5" scope="col">Description</th>
                    <th class="col-md-3" scope="col">Date Added</th>
                </tr>
            </thead>
            <tbody>
                @isset($stores)
                    @foreach($stores as $store)
                        <tr>
                            <th scope="row">{{ $store->id }}</th>
                            <td> {{ $store->name }}</td>
                            <td> {{ $store->description }}</td>
                            <td> {{ $store->created_at }}</td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>

        <!-- Products -->
        <h2 style='padding-bottom:15px'> <strong> Products </strong> </h2>

        <div class="col-md-12">
            <div class="card flex-md-row mb-4 shadow-sm tab-card" style='position: relative; min-height: 50px;'>
                <img class="card-img-right flex-auto d-none d-lg-block" alt="" src="https://via.placeholder.com/180x170" >

                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary"> PVC delovi </strong>
    
                    <p class="card-text mb-auto" style='font-size: 14px'>This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                </div>

                <div style='position: absolute; bottom: 5px; left: 197px;'> 
                    <i style='font-size:14px; color:#999'> Created by: </i>
                </div>

                <div style='position: absolute; bottom: 5px; left: 700px;'> 
                    <i style='font-size:14px; color:#999'> Date: </i>
                </div>
            </div>
        </div>

    </div>
  


</div>
@endsection
