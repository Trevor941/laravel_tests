@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($products as $product)
                <div class="col-md-3 p-3 bg-light">
                    <div class="wrapper text-center">
                        <img src="{{asset('images/'.$product->image)}}" alt="">
                        <h3><a href="{{route('products.show', $product->id)}}">{{$product->name}}</a></h3>
                        <p>{{$product->price}}</p>
                        <a href="" class="btn btn-primary">Add To Cart</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection