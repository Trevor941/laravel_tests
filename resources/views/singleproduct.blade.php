@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($productarray as $singleproduct)
                <div class="col-md-3 p-3 bg-light">
                    <div class="wrapper text-center">
                        <img src="{{asset('images/'.$singleproduct->image)}}" alt="">
                        <h3>{{$singleproduct->name}}</h3>
                        <p>{{$singleproduct->price}}</p>
                       <form action="{{route('addtocart')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$singleproduct->id}}">
                        <input type="hidden" name="name" value="{{$singleproduct->name}}">
                        <input type="hidden" name="price" value="{{$singleproduct->price}}">
                        <input type="hidden" name="saleprice" value="{{$singleproduct->saleprice}}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="image" value="{{$singleproduct->image}}">
                        <button href="" class="btn btn-primary">Add To Cart</button>
                       </form>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
@endsection