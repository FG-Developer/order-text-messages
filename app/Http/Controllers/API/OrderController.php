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

        $sms_text = "Thank You for your order! We took your order as " . $request_data['restaurant_name']
            . " and We will have your order delivered within "
            . $request_data['delivery_time'] . " minutes.";
        $model_data = array_merge($request_data, ['status' => 1, 'status_msg' => 'In Queue', 'message' => $sms_text]);
        $message = Message::create($model_data);

        if($message){

            $message->notify(new OrderMessage($sms_text));

            $sms_text = $request_data['restaurant_name'] .
            ". Enjoy your meal! We are happy for delivered your order. If you give a vote to our restaurant, we will be happy :)";
            $model_data = array_merge($request_data, ['status' => 1, 'status_msg' => 'In Queue', 'message' => $sms_text]);
            $message = Message::create($model_data);

            if($message){
                $when = now()->addMinutes($request_data['delivery_time'] + 90);
                $message->notify((new OrderMessage($sms_text))->delay($when));
            } else {
                $response = ['status' => 500, 'msg' => 'Internal Server Error'];
                return response()->json($response, 500);
            }

        } else {
            $response = ['status' => 500, 'msg' => 'Internal Server Error'];
            return response()->json($response, 500);
        }

        return response()->json($response, 201);
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
