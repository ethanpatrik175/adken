<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       

        if ($request->ajax()) {
            $data = Order::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if(json_decode($row->payment_details))
                    {
                        $reciept = json_decode($row->payment_details)->receipt_url; 
                        $btn .= '<a href="'.$reciept.'" class="btn btn-success btn-sm mt-1" target="__blank">Receipt</a>&nbsp;';
                    }
                    $btn .= '<a href="'.route('admin.orders.edit', $row->id).'" class="btn btn-primary btn-sm mt-1">Edit</a>&nbsp;';
                    $btn .= '<a href="'.route('admin.orders.show', $row->order_number).'" class="btn btn-success btn-sm mt-1" target="__blank">Show</a>&nbsp;';
                    return $btn;
                    
                    
                })
                ->addColumn('customer', function ($row) {
                    $shipping = json_decode($row->shipping_details);
                    $html = '<b>' . $shipping->first_name . ' ' . $shipping->last_name . ",</b> <br />";
                    $html .= 'Email: <a href="mailto:' . $shipping->email . '">' . $shipping->email . '</a> <br />';
                    $html .= 'Phone: <a href="tel:' . $shipping->phone . '">' . $shipping->phone . '</a>';
                    return $html;
                })
                ->addColumn('billing_address', function ($row) {
                    $billing = json_decode($row->billing_details, true);
                    if (isset($billing) && (count((array)$billing) > 0)) {
                        $html = '<strong>Address: </strong>'.$billing['address1'] . ' , <strong>City: </strong>' . $billing['city'] . '<br />';
                        $html .= '<strong>Billing State Code:</strong> ' . $billing['billingState'] . ', Zipcode: ' . $billing['billingZip'];
                    }else{
                        $html = 'Shipping and Billing address are same.';
                    }
                    return $html;
                })
                ->addColumn('shipping_address', function ($row) {
                    $shipping = json_decode($row->shipping_details);
                    $html = '<b>' . $shipping->first_name . ' ' . $shipping->last_name . ",</b> <br />";
                    $html .= 'Email: <a href="mailto:' . $shipping->email . '">' . $shipping->email . '</a> <br />';
                    $html = $shipping->address . ' ,' . $shipping->city . '<br />';
                    $html .= 'Shipping State Code: ' . $shipping->shipState . ', Zipcode: ' . $shipping->zipcode;
                    $html .= 'Phone: <a href="tel:' . $shipping->phone . '">' . $shipping->phone . '</a>';
                    return $html;
                })
                ->addColumn('total', function ($row) {
                    return '$' . number_format($row->sub_total + $row->shipping_charges, 2);
                })
                ->addColumn('created_at', function ($row) {
                    $date = date('d-M-Y h:i:s a', strtotime($row->created_at)) . "<br /><label class='text-primary'>" . Carbon::parse($row->created_at)->diffForHumans() . "</label>";
                    return $date;
                })
                ->addColumn('status', function ($row) {
                    $status = '<span class="badge badge-pill badge-soft-info">' . Str::of($row->status)->upper() . '</span>';
                    return $status;
                })
                ->rawColumns(['action', 'customer', 'billing_address', 'status', 'shipping_address', 'total', 'created_at'])
                ->make(true);
        }
        return view('backend.admin.order.orders');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order_number)
    {
        // dd($order_number);
        $data['orders'] = Order::with('products')->where('order_number',$order_number)->first();
        $data['Billings_details'] = json_decode($data['orders']->billing_details);
        $data['product'] = $data['orders']->products;
        $data['shipping_detail'] = json_decode($data['orders']->shipping_details);
        $data['payment_detail'] = json_decode($data['orders']->payment_details);
        $data['payment_method_detail'] = $data['payment_detail']->payment_method_details->card;
        return view('backend.admin.order.show',$data);
        
      
    
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data['order'] = Order::findorfail($id);
        return view('backend.admin.order.edits', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request ,$id) 
    {
        $Order = Order::findOrFail($id);
            $Order->status = $request->status;
            $Order->description = $request->description;
                if ($Order->save()) {
                    $data['type'] = "success";
                    $data['message'] = "Order Updated Successfuly!.";
                    $data['icon'] = 'mdi-check-all';
    
                    return redirect()->route('admin.orders.index')->with($data);
                } else {
                    $data['type'] = "danger";
                    $data['message'] = "Failed to Update Order, please try again.";
                    $data['icon'] = 'mdi-block-helper';
    
                    return redirect()->route('admin.orders.edit', $id)->withInput()->with($data);
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
