<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{

    public function index(){
        return view('index');
    }

    public function indexProcess(Request $request){
        $request->validate([
            'device_type' => 'required'
        ], [
            'device_type.required' => 'Select your device to get started'
        ]);

        $request->session()->put('index', $request->device_type);
        return redirect()->route('step1');
    }

    public function step1(){
        return view('step1');
    }

    public function step1Process(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ], [
            'code.required' => 'Enter valid Zipcode'
        ]);

        $url = "http://api.zippopotam.us/us/".$request->code;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        
        if(count(json_decode($resp, true)) == 0){
            $data['type'] = "danger";
            $data['message'] = "Invalid Zipcode, please enter valid zipcode!";
            return redirect()->route('step1')->with($data);
        }

        $request->session()->put('step1', $request->code);
        return redirect()->route('step2');
    }

    public function step2(){
        // dd(request()->all(), request()->session());
        return view('step2');
    }
    
    public function step2Process(Request $request)
    {
        $request->session()->put('step2', $request->offer);
        return redirect()->route('step3');
    }

    public function step3()
    {
        return view('step3');
    }

    public function step3Process(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required'
        ]);

        $request->session()->put('step3', $request->all());
        return redirect()->route('step4');
    }

    public function step4()
    {
        return view('step4');
    }

    public function step4Process(Request $request)
    {
        $request->validate([
            'repair_problem' => 'required'
        ], [
            'repair_problem.required' => 'Select Repair Problem'
        ]);

        $request->session()->put('step4', $request->repair_problem);

        return redirect()->route('step5');
    }

    public function step5()
    {
        return view('step5');
    }

    public function step5Process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:3|max:20',
            'last_name' => 'nullable|min:3|max:20',
            'email' => 'required|email'
        ]);

        $step1 = $request->session()->get('step1');
        $step2 = $request->session()->get('step2');
        $step3 = $request->session()->get('step3');
        $step4 = $request->session()->get('step4');

        $appointment = new Appointment();
        $appointment->code = Str::random(10).date('him', time());
        $appointment->first_name = $request->first_name;
        $appointment->last_name = $request->last_name;
        $appointment->email =  $request->email;
        $appointment->phone = $request->phone_number;
        $appointment->step1 = json_encode($step1);
        $appointment->step2 = json_encode($step2);
        $appointment->step3 = json_encode($step3);
        $appointment->step4 = json_encode($step4);
        $appointment->status = 'new';
        
        if($appointment->save())
        {
            $request->session()->forget('index');
            $request->session()->forget('step1');
            $request->session()->forget('step2');
            $request->session()->forget('step3');
            $request->session()->forget('step4');

            $data['type'] = 'success';
            $data['message'] = 'Appointment Saved Successfully!';
            $data['toUrl'] = 'https://yourwebsitedemos.com/web/La-tech-and-repair/product/place-order-now/';
        }
        else{
            $data['type'] = 'danger';
            $data['message'] = 'Failed to save data, please try again!';
        }

        return json_encode($data);
    }  
}
