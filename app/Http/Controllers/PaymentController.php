<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    public function payment(){
        return view('payment');
    }

    function verifypayment(Request $request, $transaction_id){
        $request->session()->put('transaction_id', $transaction_id);
        return redirect('/completepayment');

    }

    function completepayment(Request $request){
        if($request->session()->has('order_id') && $request->session()->has('transaction_id')){
        $order_id = $request->session()->get('order_id');
        $transaction_id = $request->session()->get('transaction_id');
        $order_status = 'paid';
        $payment_date = date('Y-m-d h:i:s');

        //change order status to paid 
        $affected = DB::table('orders')
        ->where('id', $order_id)
        ->update(['status'=>$order_status]);

        //store payment info in payments table
        DB::table('payments')->insert([
            'order_id'=>$order_id,
            'transaction_id' => $transaction_id,
            'date' => $payment_date
        ]);

        //remove everything from the session
        $request->session()->flush();
        return redirect('/thankyou')->with('order_id',  $order_id);



    }
    else{
        return redirect('/');
    }
}

public function thankyou(){
    return view('thankyou');
}
}
