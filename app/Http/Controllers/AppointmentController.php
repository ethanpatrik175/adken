<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use DataTables;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = Appointment::whereNull('deleted_at')->get();
        // dd($data);
        // dd($request->ajax());
        if ($request->ajax()) {
            $data = Appointment::whereNull('deleted_at')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('zipcode', function ($row) {
                    return json_decode($row->step1);
                })
                ->addColumn('brand', function ($row) {
                    return json_decode($row->step3, true)['brand'];
                })
                ->addColumn('model', function ($row) {
                    return json_decode($row->step3, true)['model'];
                })
                ->addColumn('problem', function ($row) {
                    return json_decode($row->step4);
                })
                ->addColumn('customer', function ($row) {
                    $customer = '';
                    $customer .= 'Name: '.$row->first_name.' '.$row->last_name ?? '';
                    $customer .= '<br />Email: '.$row->email;
                    $customer .= '<br />Phone: '.$row->phone;
                    return $customer;
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-M-Y h:i A', strtotime($row->created_at));
                })
                ->rawColumns(['zipcode', 'brand', 'model', 'problem', 'customer'])
                ->make(true);
        }

        return view('backend.admin.appointments.index');
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
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
