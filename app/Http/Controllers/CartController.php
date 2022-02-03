<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function cart(){

        return view('cart');
    }

    public function addtocart(Request $request){
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart');
            $products_array_ids = array_column($cart, 'id');
            $id = $request->input('id');
            

            if(!in_array($id, $products_array_ids)){
                $id = $request->input('id');
                $name = $request->input('name');
                $image = $request->input('image');
                $price = $request->input('price');
                $quantity = $request->input('quantity');
                $saleprice = $request->input('saleprice');
                
                if($saleprice != null){
                    $pricetocharge = $saleprice;
                }
                else{
                    $pricetocharge = $price;
                }

                $product_array = array(
                    'id' => $id,
                    'name' => $name,
                    'image' => $image,
                    'price' => $pricetocharge,
                    'quantity' => $quantity


                );

                $cart[$id] = $product_array;
                $request->session()->put('cart', $cart);
            }
            //product is already in cart
            else{
                // echo "<script>alert('product is already in the cart')</script>";
                $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
                $request->session()->put('cart', $cart);

            }
            $this->calculateTotalCart($request);
        return view('cart');
        }
        // if we dont have a cart in session
        else{
            $cart = array();
            $id = $request->input('id');
            $name = $request->input('name');
                $image = $request->input('image');
                $price = $request->input('price');
                $quantity = $request->input('quantity');
                $saleprice = $request->input('saleprice');
                
                if($saleprice != null){
                    $pricetocharge = $saleprice;
                }
                else{
                    $pricetocharge = $price;
                }

                $product_array = array(
                    'id' => $id,
                    'name' => $name,
                    'image' => $image,
                    'price' => $pricetocharge,
                    'quantity' => $quantity


                );

                $cart[$id] = $product_array;
                $request->session()->put('cart', $cart);

                $this->calculateTotalCart($request);
            return view('cart');


        }

       
    }

    function calculateTotalCart(Request $request){
        $cart = $request->session()->get('cart');
        $totalprice = 0;
        $totalquantity = 0;

        foreach($cart as $id=>$product){
            $product = $cart[$id];
            $price = $product['price'];
            $quantity = $product['quantity'];
            $totalprice = $totalprice + ($price * $quantity);
            $totalquantity =  $totalquantity + $quantity;
        }

        $request->session()->put('total', $totalprice);
        $request->session()->put('quantity', $totalquantity);
    }

    function removefromcart(Request $request){

        if($request->session()->has('cart')){
            $id = $request->input('id');
            $cart = $request->session()->get('cart');
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
            $this->calculateTotalCart($request);

        }

        return view('cart');
    }

    function editproductquantity(Request $request){
        if($request->session()->has('cart')){
            $product_id = $request->input('id');
            $product_quantity = $request->input('quantity');

            if($request->has('increaseproductquantity')){
                $product_quantity = $product_quantity + 1;
            }else if($request->has('decreaseproductquantity')){
                $product_quantity = $product_quantity - 1;
            }else{

            }

            $cart = $request->session()->get('cart');
            if(array_key_exists($product_id, $cart)){
                $cart[$product_id]['quantity'] = $product_quantity;

                $request->session()->put('cart', $cart);

                $this->calculateTotalCart($request);
            }
        }
        return view('cart'); 
    }

    public function checkout(){
        return view('checkout');
    }

    public function placeorder(Request $request){
        if($request->session()->has('cart')){
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $city = $request->input('city');
            $address = $request->input('address');

            $cost = $request->session()->get('total');
            $status = "not paid";
            $date = date('Y-m-d h:i:s');

            $cart = $request->session()->get('cart');

          $order_id =  DB::table('orders')->InsertGetId([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'city' => $city,
                'address' => $address,
                'cost' => $cost,
                'status' => $status,
                'date' => $date,
            ], 'id');

            foreach($cart as $id => $product){
                $product = $cart[$id];
                $product_id = $product['id'];
                $product_name = $product['name'];
                $product_price = $product['price'];
                $product_quantity = $product['quantity'];
                $product_image = $product['image'];
               
                DB::table('order_items')->insert([
                    'order_id'=>$order_id,
                    'product_id'=>$product_id,
                    'product_name'=>$product_name,
                    'product_price'=>$product_price,
                    'product_quantity'=>$product_quantity,
                    'product_image'=>$product_image,
                    'order_date'=>$date,


                ]);
            }

            $request->session()->put('order_id', $order_id);

            return view('payment');
        }

        else{
            return redirect('/');
        }
    }
}
