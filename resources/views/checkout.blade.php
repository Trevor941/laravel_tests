@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 p-5 bg-white bg-round" style="border: 5px solid #eee; border-radius: 5px;">
                <h3 class="text-center">Checkout</h3>
                <hr>

                <form id="checkoutform" action="{{route('placeorder')}}" method="POST">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" id="checkout-name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email" id="checkout-name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Phone</label>
                        <input type="text" class="form-control" name="phone" id="checkout-name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">City</label>
                        <input type="text" class="form-control" name="city" id="checkout-name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" id="checkout-name" required>
                    </div>
                    @if (Session::has('total'))
                        @if (Session::get('total') !== null)
                    <div class="form-group mt-3">
                        <p>Total Amount:<b>{{Session::get('total')}} </b></p>
                        <input type="submit" value="checkout" class="btn btn-primary" name="checkout-btn" id="checkout-btn">
                    </div>
                       @endif
                    @endif


                </form>
            </div>
        </div>
    </div>

 @endsection
