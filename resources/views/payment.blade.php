@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h4>Payment</h4>
                @if(Session::has('total') && Session::get('total')  !==null)
                @if(Session::has('order_id')&& Session::get('order_id')  !==null)
                <h4>Total : ${{Session::get('total')}}</h4>
                <div id="paypal-button-container"></div>
                @endif
                @endif

            </div>
        </div>
    </div>


     <!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
     <script src="https://www.paypal.com/sdk/js?client-id=AcLF1SNKRsHXcyTRVL4Ubbe-sVC4_eyyzLEKVXZ1vxJywctwC5OT1GlT9wg2pysw4Iq9SrCld2zYK6LI&currency=USD"></script>

     <!-- Set up a container element for the button -->
     
 
     <script>
       paypal.Buttons({
 
         // Sets up the transaction when a payment button is clicked
         createOrder: function(data, actions) {
           return actions.order.create({
             purchase_units: [{
               amount: {
                 value: "{{Session::get('total')}}"// Can reference variables or functions. Example: `value: document.getElementById('...').value`
               }
             }]
           });
         },
 
         // Finalize the transaction after payer approval
         onApprove: function(data, actions) {
           return actions.order.capture().then(function(orderData) {
             // Successful capture! For dev/demo purposes:
                 console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                 var transaction = orderData.purchase_units[0].payments.captures[0];
                 alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                 window.location.href="/verifypayment/"+transaction.id;
 
             // When ready to go live, remove the alert and show a success message within this page. For example:
             // var element = document.getElementById('paypal-button-container');
             // element.innerHTML = '';
             // element.innerHTML = '<h3>Thank you for your payment!</h3>';
             // Or go to another URL:  actions.redirect('thank_you.html');
           });
         }
       }).render('#paypal-button-container');
 
     </script>
@endsection