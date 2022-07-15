<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use stdClass;
use Stripe;

class StripeController extends Controller
{

    public function stripeCheckoutProcess(Request $request)
    {
        dd($request->all());
        $product = Product::findOrFail($request->id);
        $productPrice = (($product->sale_price > 0) && ($product->retail_price > $product->sale_price)) ? number_format($product->sale_price, 2) : number_format($product->retail_price, 2);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $payment = Stripe\Charge::create([
                "amount" => ($productPrice * 100),
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "This payment is for the product " . $product->name
            ]);
        } catch (\Stripe\Exception\CardException $e) {

            $data['type'] = 'danger';
            $data['message'] = $e->getError()->message;
            return redirect()->route('front.index')->with($data);
        } catch (\Stripe\Exception\InvalidRequestException $e) {

            $data['type'] = 'danger';
            $data['message'] = $e->getError()->message;
            return redirect()->route('front.index')->with($data);
        } catch (Exception $e) {
            $data['type'] = 'danger';
            $data['message'] = $e->getError()->message;
            return redirect()->route('front.index')->with($data);
        }

        $charge = new stdClass;
        $charge->charge_id = $payment->id;
        $charge->description = $payment->description;
        $charge->paid = $payment->paid;
        $charge->payment_method = $payment->payment_method;
        $charge->payment_method_details = $payment->payment_method_details;
        $charge->receipt_url = $payment->receipt_url;
        $charge->refunds = $payment->refunds;
        $charge->succeeded = $payment->succeeded;

        if ($request->billShipSame == 0) {
            $billing['address1'] = $request->address1;
            $billing['city'] = $request->city;
            $billing['billingZip'] = $request->billingZip;
            $billing['billingState'] = $request->billingState;
        } else {
            $billing = array();
        }

        $subTotal = number_format($productPrice * $product->quantity, 2);
        $total = number_format($subTotal + $product->shipping_charges, 2);
        
        $orderNumber = 'ADK' . date('ymdhis', time()) . Str::random(5) . $product->id;
        
        $order = new Order();
        $order->product_id = $product->id;
        $order->order_number = $orderNumber;
        $order->quantity = $product->quantity;
        $order->sub_total = $subTotal;
        $order->shipping_charges = number_format($product->shipping_charges, 2);
        $order->total = $total;
        $order->shipping_details = json_encode($request->session()->get('shipping_details'));
        $order->billing_details = json_encode($billing);
        $order->billing_same_as_shipping = $request->billShipSame;
        $order->payment_details = json_encode($charge);

        if ($order->save()) {

            $app= App::getFacadeRoot();
            $shipStation = $app['LaravelShipStation\ShipStation'];

            $shipping = request()->session()->get('shipping_details');

            $address = new \LaravelShipStation\Models\Address();
            $address->name = $shipping['first_name'] . ' ' . @$shipping['last_name'];
            $address->street1 = $shipping['address'];
            $address->city = $shipping['city'];
            $address->state = $shipping['shipState'];
            $address->postalCode = $shipping['zipcode'];
            $address->country = "US";
            $address->phone = $shipping['phone'];

            $item = new \LaravelShipStation\Models\OrderItem();
            $item->lineItemKey = $product->id;
            $item->sku = json_decode($product->metadata)->sku;
            $item->name = $product->name;
            $item->quantity = '1';
            $item->unitPrice  = $productPrice;
            $item->imageUrl = asset('assets/frontend/images/products/' . Str::of($product->image)->replace(' ', '%20'));

            $shipStationOrder = new \LaravelShipStation\Models\Order();
            $shipStationOrder->orderNumber = $orderNumber;
            $shipStationOrder->orderDate = date('Y-m-d', time());
            $shipStationOrder->orderStatus = 'awaiting_shipment';
            $shipStationOrder->amountPaid = $total;
            $shipStationOrder->taxAmount = '0.00';
            $shipStationOrder->shippingAmount = '0.00';
            $shipStationOrder->customerEmail = $shipping['email'];
            $shipStationOrder->billTo = $address;
            $shipStationOrder->shipTo = $address;
            $shipStationOrder->items[] = $item;

            try {
                // $shipStation->orders->post($order, 'createorder');
                $shipStation->orders->create($order);
            } catch (\Exception $e) {
                Log::info('Some Error Occured While Creating Order in ShipStation');
            }
            
            Session::forget('shipping_details');
            Session::save();

            $data['type'] = 'success';
            $data['message'] = "Your order has been placed successfully!";
            return redirect()->route('checkout.summary', $order->order_number)->with($data);
        } else {
            $data['type'] = 'danger';
            $data['message'] = "Something went wrong, please try again!.";
            return redirect()->route('front.index')->with($data);
        }
    }
    
}
