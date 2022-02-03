@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(Session::has('cart'))
                        @foreach(Session::get('cart') as $product)
                        <tr>
                            <td>{{$product['name']}}
                            <form action="{{route('removefromcart')}}" method="POST">
                                <input type="hidden" value="{{$product['id']}}" name="id" >
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                            </td>
                            <td><img src="{{asset('images/'.$product['image'])}}" alt="" width="50" height="50"></td>
                            <td>
                                <form action="{{route('editproductquantity')}}" method="POST">
                                    @csrf
                                    <input type="submit" value="-" name="decreaseproductquantity">
                                    <input type="hidden" value="{{$product['id']}}" name="id" >
                                    <input type="text" name="quantity" value="{{$product['quantity']}}" readonly>
                                    <input type="submit" value="+" name="increaseproductquantity">
                                </form>
                            </td>
                            <td>{{$product['price'] * $product['quantity']}}</td>
                        </tr>
                        @endforeach
                        @endif
                        @if(Session::has('cart'))
                       <tr>
                           <td></td>
                           <td></td>
                           <td>Total</td>
                           @if(Session::has('total'))
                           <td>${{Session::get('total')}}</td>
                           @endif
                       </tr>
                       @endif
                       <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if (Session::has('total'))
                        @if (Session::get('total') !== null)
                        <td>
                            <form method="GET" action="{{route('checkout')}}">
                                <input type="submit" class="btn btn-primary" value="Checkout">
                            </form>
                        </td> 
                        @endif
                        @endif
                       
                       </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection