<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\OrderRequests;
use App\Message;
use App\Notifications\OrderMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\OrderRequests  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequests $request)
    {
        $response = ['status' => 200, 'msg' => 'Success'];
        $request_data = $request->all();
        
        $sms_text = "Thank You thank You for your order! We took your order as " . $request_data['restaurant_name']
            . " and we will be delivered your order to you in "
            . $request_data['delivery_time'] . " minutes.";
        
        try{
            Notification::route('nexmo', $request_data['customer_phone_number'])->notify(new OrderMessage($sms_text));
    
            $when = now()->addMinutes($request_data['delivery_time'] + 90);
            $sms_text = $request_data['restaurant_name'] . ". Enjoy your meal! We are happy for delivered your order. If you give vote, to our restaurant, we will be happy :)";
            Notification::route('nexmo', $request_data['customer_phone_number'])->notify((new OrderMessage($sms_text))->delay($when));
            
            $request_data = array_merge($request_data, ['status' => 0]);
        } catch (\Exception $e){
            $request_data = array_merge($request_data, ['status' => $e->getCode(), 'error_text' => $e->getMessage()]);
            $response = ['status' => $e->getCode(), 'msg' => $e->getMessage()];
        }
        
        $insert = Message::create($request_data);
    
        if(!$insert){
            $response = ['status' => 500, 'msg' => 'Internal Server Error'];
        }
        
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
