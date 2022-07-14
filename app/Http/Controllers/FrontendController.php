<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;

class FrontendController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function indexProcess(Request $request)
    {
        if(isset($request->contact))
        {
            $request->session()->put('shipping_details', $request->contact);
        }
        else
        {
            $request->validate([
                "first_name" => "required|string|min:3|max:20",
                "last_name" => "required|string|min:3|max:20",
                "address" => "required",
                "city" => "required",
                "shipState" => "required",
                "zipcode" => "required",
                "phone" => "required",
                "email" => "required|email"
            ]);
            
            $shipping['first_name'] = $request->first_name ?? '';
            $shipping['last_name'] = $request->last_name ?? '';
            $shipping['address'] = $request->address ?? '';
            $shipping['city'] = $request->city ?? '';
            $shipping['shipState'] = $request->shipState ?? '';
            $shipping['zipcode'] = $request->zipcode ?? '';
            $shipping['phone'] = $request->phone ?? '';
            $shipping['email'] = $request->email ?? '';
            
            $request->session()->put('shipping_details', $shipping);
        }
        

        return redirect()->route('front.checkout');
    }

    public function checkout(Request $request)
    {
        if(!Session::has('shipping_details'))
        {
            return redirect()->route('front.index');
        }

        $data['products'] = Product::where('is_active', 1)->get();
        $data['totalProducts'] = Product::where('is_active', 1)->get()->count();

        return view('checkout', $data);
    }

    // public function checkoutProcess(Request $request)
    // {
    //     $product = Product::findOrFail($request->id);
    //     if($request->billShipSame == 0)
    //     {
    //         $billing['address1'] = $request->address1;
    //         $billing['city'] = $request->city;
    //         $billing['billingZip'] = $request->billingZip;
    //         $billing['billingState'] = $request->billingState;
    //     }
    //     else{
    //         $billing = array();
    //     }

    //     $productPrice = $product->sale_price > 0 && $product->retail_price > $product->sale_price ? number_format($product->sale_price, 2) : number_format($product->retail_price, 2);
    //     $subTotal = number_format($productPrice * $product->quantity, 2);
    //     $total = number_format($subTotal + $product->shipping_charges, 2);

    //     $order = new Order();
    //     $order->product_id = $product->id;
    //     $order->order_number = 'ADK'.date('ymdhis', time()).Str::random(5).$product->id;
    //     $order->quantity = $product->quantity;
    //     $order->sub_total = $subTotal;
    //     $order->shipping_charges = number_format($product->shipping_charges, 2);
    //     $order->total = $total;
    //     $order->shipping_details = json_encode($request->session()->get('shipping_details'));
    //     $order->billing_details = json_encode($billing);
    //     $order->billing_same_as_shipping = $request->billShipSame;
    //     $order->payment_details = json_encode(array());

    //     if($order->save())
    //     {
    //         $request->session()->forget('shipping_details');
    //         $data['type'] = 'success';
    //         $data['message'] = "Your order has been placed successfully!";
    //         return redirect()->route('checkout.summary', $order->order_number)->with($data);
    //     }
    //     else
    //     {
    //         $data['type'] = 'danger';
    //         $data['message'] = "Something went wrong, please try again!.";
    //         return redirect()->route('front.index')->with($data);
    //     }
    // }

    public function summary($orderNumber, Request $request)
    {
        $data['order'] = Order::where('order_number', $orderNumber)->first();
        $data['products'] = Product::where('id', $data['order']->product_id)->get();
        return view('summary', $data);
    }

    public function aboutCvv()
    {
        return view('about-cvv');
    }

    public function terms()
    {
        return view('terms');   
    }
    
    public function privacy()
    {
        return view('privacy');   
    }
    
    public function contactUs()
    {
        return view('contact');   
    }
}
