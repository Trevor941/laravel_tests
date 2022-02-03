@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4>Thank you</h4>
                @if(Session::has('order_id')&& Session::get('order_id')  !==null)
                <h4>Order id : {{Session::get('order_id')}}</h4>
                <p>Keep order id in safe place for future reference</p>
                @endif
            </div>
        </div>
    </div>

    @endsection