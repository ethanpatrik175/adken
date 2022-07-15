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

        $order = new Order();
        $order->product_id = $product->id;
        $order->order_number = 'ADK' . date('ymdhis', time()) . Str::random(5) . $product->id;
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
            $shipStationOrder->orderNumber = $order->order_number;
            $shipStationOrder->orderDate = date('Y-m-dTG:i', time());
            $shipStationOrder->orderStatus = 'awaiting_shipment';
            $shipStationOrder->amountPaid = $total;
            $shipStationOrder->taxAmount = '0.00';
            $shipStationOrder->shippingAmount = '0.00';
            $shipStationOrder->billTo = $address;
            $shipStationOrder->shipTo = $address;
            $shipStationOrder->items[] = $item;

            $shipStation->orders->create($order);
            // try {
            //     // $shipStation->orders->post($order, 'createorder');
            //     $shipStation->orders->create($order);
            // } catch (\Exception $e) {
            //     Log::info('Some Error Occured While Creating Order in ShipStation');
            // }
            
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

    // Create a new order in ship station
    public function createOrder()
    {
        $product = Product::findOrFail(1);
        $orderNumber = '';
        $date = date('Y-m-dTG:i', time());
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://ssapi.shipstation.com/orders/createorder",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"orderNumber\": \"$orderNumber\",\n  \"orderDate\": \"$date\",\n  \"paymentDate\": \"$date\",\n  \"orderStatus\": \"awaiting_shipment\",\n  \"customerUsername\": \"$customerEmail\",\n  \"customerEmail\": \"$customerEmail\",\n  \"billTo\": {\n    \"name\": \"$billTo\",\n    \"company\": $billCompany,\n    \"street1\": $billStreet,\n    \"street2\": null,\n    \"street3\": null,\n    \"city\": $billStreet,\n    \"state\": $billState,\n    \"postalCode\": $billPostal,\n    \"country\": $billCountry,\n    \"phone\": $billPhone,\n    \"residential\": null\n  },\n  \"shipTo\": {\n    \"name\": \"$shipTo\",\n    \"company\": \"$shipCompany\",\n    \"street1\": \"$shipStreet\",\n    \"street2\": \"null\",\n    \"street3\": null,\n    \"city\": \"$shipCity\",\n    \"state\": \"$shipState\",\n    \"postalCode\": \"$shipPostal\",\n    \"country\": \"$shipCountry\",\n    \"phone\": \"$shipPhone\",\n    \"residential\": null\n  },\n  \"items\": [\n    {\n      \"lineItemKey\": \"null\",\n      \"sku\": \"$product->sku\",\n      \"name\": \"Test item #1\",\n      \"imageUrl\": null,\n      \"weight\": {\n        \"value\": 24,\n        \"units\": \"ounces\"\n      },\n      \"quantity\": 2,\n      \"unitPrice\": 99.99,\n      \"taxAmount\": 2.5,\n      \"shippingAmount\": 5,\n      \"warehouseLocation\": \"Aisle 1, Bin 7\",\n      \"options\": [\n        {\n          \"name\": \"Size\",\n          \"value\": \"Large\"\n        }\n      ],\n      \"productId\": 123456,\n      \"fulfillmentSku\": null,\n      \"adjustment\": false,\n      \"upc\": \"32-65-98\"\n    },\n    {\n      \"lineItemKey\": null,\n      \"sku\": \"DISCOUNT CODE\",\n      \"name\": \"10% OFF\",\n      \"imageUrl\": null,\n      \"weight\": {\n        \"value\": 0,\n        \"units\": \"ounces\"\n      },\n      \"quantity\": 1,\n      \"unitPrice\": -20.55,\n      \"taxAmount\": null,\n      \"shippingAmount\": null,\n      \"warehouseLocation\": null,\n      \"options\": [],\n      \"productId\": 123456,\n      \"fulfillmentSku\": \"SKU-Discount\",\n      \"adjustment\": true,\n      \"upc\": null\n    }\n  ],\n  \"amountPaid\": 218.73,\n  \"taxAmount\": 5,\n  \"shippingAmount\": 10,\n  \"customerNotes\": \"Please ship as soon as possible!\",\n  \"internalNotes\": \"Customer called and would like to upgrade shipping\",\n  \"gift\": true,\n  \"giftMessage\": \"Thank you!\",\n  \"paymentMethod\": \"Credit Card\",\n  \"requestedShippingService\": \"Priority Mail\",\n  \"carrierCode\": \"fedex\",\n  \"serviceCode\": \"fedex_2day\",\n  \"packageCode\": \"package\",\n  \"confirmation\": \"delivery\",\n  \"shipDate\": \"2015-07-02\",\n  \"weight\": {\n    \"value\": 25,\n    \"units\": \"ounces\"\n  },\n  \"dimensions\": {\n    \"units\": \"inches\",\n    \"length\": 7,\n    \"width\": 5,\n    \"height\": 6\n  },\n  \"insuranceOptions\": {\n    \"provider\": \"carrier\",\n    \"insureShipment\": true,\n    \"insuredValue\": 200\n  },\n  \"internationalOptions\": {\n    \"contents\": null,\n    \"customsItems\": null\n  },\n  \"advancedOptions\": {\n    \"warehouseId\": 98765,\n    \"nonMachinable\": false,\n    \"saturdayDelivery\": false,\n    \"containsAlcohol\": false,\n    \"mergedOrSplit\": false,\n    \"mergedIds\": [],\n    \"parentId\": null,\n    \"storeId\": 12345,\n    \"customField1\": \"Custom data that you can add to an order. See Custom Field #2 & #3 for more info!\",\n    \"customField2\": \"Per UI settings, this information can appear on some carrier's shipping labels. See link below\",\n    \"customField3\": \"https://help.shipstation.com/hc/en-us/articles/206639957\",\n    \"source\": \"Webstore\",\n    \"billToParty\": null,\n    \"billToAccount\": null,\n    \"billToPostalCode\": null,\n    \"billToCountryCode\": null\n  },\n  \"tagIds\": [\n    53974\n  ]\n}",
            CURLOPT_HTTPHEADER => array(
                "Host: ssapi.shipstation.com",
                "Authorization: 0a032e9059124de08b7fc7dbad6dee92:dd9a99c0df77463681ac8211471d3890",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function createNewOrder()
    {
    }
}
