<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $app= App::getFacadeRoot();
        $shipStation = $app['LaravelShipStation\ShipStation'];
        dd($shipStation);

        if ($request->ajax()) {
            $data = DB::table('products')
                ->leftJoin('users', 'products.added_by', '=', 'users.id')
                ->leftJoin('users as users_updated', 'products.updated_by', '=', 'users_updated.id')
                ->select('products.*', 'users.first_name', 'users.last_name', 'users_updated.first_name as updated_by_first_name', 'users_updated.last_name as updated_by_last_name', 'users.role as addedBy', 'users_updated.role as updatedBy')
                ->whereNull('products.deleted_at')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.products.edit', $row->id) . '" target="_blank"><i title="Edit" class="fas fa-edit font-size-18"></i></a>';
                    // $btn .= ' <a href="javascript:void(0);" class="text-danger remove" data-id="' . $row->id . '"><i title="Delete" class="fas fa-trash-alt font-size-18"></i></a>';
                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at)) . '<br /> <label class="text-primary">By: ' . $row->first_name . ' ' . $row->last_name . '</label>';
                })
                ->addColumn('updated_at', function ($row) {
                    return date('d-M-Y', strtotime($row->updated_at)) . '<br /> <label class="text-primary">By: ' . $row->updated_by_first_name . ' ' . $row->updated_by_last_name . '</label>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_active == 0) {

                        $btn0 = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="product_status" switch="bool" data-id="' . $row->id . '" value="1"/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';
                        return $btn0;
                    } elseif ($row->is_active == 1) {

                        $btn1 = '<div class="square-switch"><input type="checkbox" id="switch' . $row->id . '" class="product_status" switch="bool" data-id="' . $row->id . '" value="0" checked/><label for="switch' . $row->id . '" data-on-label="Yes" data-off-label="No"></label></div>';
                        return $btn1;
                    }
                })
                ->addColumn('image', function ($row) {
                    $imageName = Str::of($row->image)->replace(' ', '%20');
                    if ($row->image) {
                        $image = '<img src=' . asset('assets/frontend/images/products/' . $imageName) . ' class="avatar-sm" />';
                    } else {
                        $image = '<img src=' . asset('assets/backend/images/no-image.jpg') . ' class="avatar-sm" />';
                    }
                    return $image;
                })
                ->addColumn('description', function ($row) {
                    return Str::of($row->description)->limit(100);
                })
                ->addColumn('prices', function ($row) {
                    $price = '';
                    $price .= '<strong>Retail Price:</strong> $'. number_format($row->retail_price, 2) .'<br />';
                    $price .= '<strong>Sale Price</strong> $'. number_format($row->sale_price, 2) .'<br />';
                    $price .= '<strong>Shipping Charges</strong> $'. number_format($row->shipping_charges, 2);
                    
                    return $price;
                })
                ->rawColumns(['action', 'created_at', 'status', 'image', 'description', 'updated_at', 'prices'])
                ->make(true);
        }
        return view('backend.admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:254',
            'slug' => 'required|max:250',
            'retail_price' => 'required',
            'packing_type' => 'required|max:20',
            'image' => 'required|image|max:1024',
            'summary_image' => 'required|image|max:1024',
            'quantity' => 'required',
            'sku' => 'required|max:20'
        ]);

        $product = new Product();
        $product->added_by = Auth::user()->id;
        $product->name = $request->name ?? '';
        $product->slug = Str::slug($request->slug) ?? '';
        $product->description = $request->description ?? '';
        $product->retail_price = $request->retail_price ?? '';
        $product->sale_price = $request->sale_price ?? 0;
        $product->shipping_charges = $request->shipping_charges ?? 0;
        $product->quantity = $request->quantity ?? 0;
        $product->stock_alert_quantity = $request->stock_alert_quantity ?? 0;
        $product->type = $request->packing_type ?? '';
        $product->is_sample = ($request->is_sample == 'yes') ? 1 : 0;

        $metadata['meta_title'] = $request->meta_title ?? '';
        $metadata['meta_description'] = $request->meta_description ?? '';
        $metadata['meta_keywords'] = $request->meta_keywords ?? '';
        $metadata['sku'] = $request->sku ?? '';

        $product->metadata = json_encode($metadata);

        $image = $request->file('image');
        $summaryImage = $request->file('summary_image');
        if ($image->move('assets/frontend/images/products/', $image->getClientOriginalName()) && $summaryImage->move('assets/frontend/images/products/', $summaryImage->getClientOriginalName())) {

            $product->image = $image->getClientOriginalName();
            $product->summary_image = $summaryImage->getClientOriginalName();
            if ($product->save()) {
                $data['type'] = "success";
                $data['message'] = "Product Added Successfuly!.";
                $data['icon'] = 'mdi-check-all';

                return redirect()->route('admin.products.create')->with($data);
            } else {
                $data['type'] = "danger";
                $data['message'] = "Failed to Add Product, please try again.";
                $data['icon'] = 'mdi-block-helper';

                return redirect()->route('admin.products.create')->withInput()->with($data);
            }
        } else {
            $data['type'] = "danger";
            $data['message'] = "Failed to upload image, please try again.";
            $data['icon'] = 'mdi-block-helper';

            return redirect()->route('admin.products.create')->withInput()->with($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['product'] = Product::findOrFail($product->id);
        return view('backend.admin.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::findOrFail($product->id);
        
        $request->validate([
            'name' => 'required|max:254',
            'slug' => 'required|max:250',
            'retail_price' => 'required',
            'packing_type' => 'required|max:20',
            'quantity' => 'required',
            'sku' => 'required|max:20'
        ]);

        $product->updated_by = Auth::user()->id;
        $product->name = $request->name ?? '';
        $product->slug = Str::slug($request->slug) ?? '';
        $product->description = $request->description ?? '';
        $product->retail_price = $request->retail_price ?? '';
        $product->sale_price = $request->sale_price ?? 0;
        $product->shipping_charges = $request->shipping_charges ?? 0;
        $product->quantity = $request->quantity ?? 0;
        $product->stock_alert_quantity = $request->stock_alert_quantity ?? 0;
        $product->type = $request->packing_type ?? '';
        $product->is_sample = ($request->is_sample == 'yes') ? 1 : 0;

        $metadata['meta_title'] = $request->meta_title ?? '';
        $metadata['meta_description'] = $request->meta_description ?? '';
        $metadata['meta_keywords'] = $request->meta_keywords ?? '';
        $metadata['sku'] = $request->sku ?? '';

        $product->metadata = json_encode($metadata);

        if ($request->file('image') || $request->file('summary_image')) {

            if($request->file('summary_image'))
            {
                $request->validate([
                    'summary_image' => 'required|image|max:1024'
                ], [
                    'summary_image.required' => 'Please upload valid image'
                ]);

                $summaryImage = $request->file('summary_image');
                if ($summaryImage->move('assets/frontend/images/products/', $summaryImage->getClientOriginalName())) {
                    $product->summary_image = $summaryImage->getClientOriginalName();
                }
            }
            
            if($request->file('image'))
            {
                $request->validate([
                    'image' => 'required|image|max:1024'
                ], [
                    'image.required' => 'Please upload valid image'
                ]);

                $image = $request->file('image');
                if ($image->move('assets/frontend/images/products/', $image->getClientOriginalName())) {
                    $product->image = $image->getClientOriginalName();
                }
            }

            if ($product->save()) {
                $data['type'] = "success";
                $data['message'] = "Product Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';

                return redirect()->route('admin.products.index')->withInput()->with($data);
            } else {
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Product, please try again.";
                $data['icon'] = 'mdi-block-helper';

                return redirect()->route('admin.products.edit', $product->id)->withInput()->with($data);
            }

        
        } else {
            if ($product->save()) {
                $data['type'] = "success";
                $data['message'] = "Product Updated Successfuly!.";
                $data['icon'] = 'mdi-check-all';

                return redirect()->route('admin.products.index')->with($data);
            } else {
                $data['type'] = "danger";
                $data['message'] = "Failed to Update Product, please try again.";
                $data['icon'] = 'mdi-block-helper';

                return redirect()->route('admin.products.edit', $product->id)->withInput()->with($data);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        abort(404);
    }

    public function createSlug(Request $request)
    {
        $slug = Str::slug($request->name);
        return $slug;
    }

    public function updateStatus(Request $request)
    {
        $update = Product::where('id', $request->id)->update(['is_active' => $request->status]);

        if ($update) {
            $request->status == 1 ? $alertType = 'success' : $alertType = 'info';
            $request->status == 1 ? $message = 'Product Activated Successfuly!' : $message = 'Product Deactivated Successfuly!';

            $notification = array(
                'message' => $message,
                'type' => $alertType,
                'icon' => 'mdi-check-all'
            );
        } else {
            $notification = array(
                'message' => 'Some Error Occured, Try Again!',
                'type' => 'error',
                'icon'  => 'mdi-block-helper'
            );
        }

        echo json_encode($notification);
    }
}
