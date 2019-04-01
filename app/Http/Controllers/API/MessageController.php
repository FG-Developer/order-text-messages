<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Message as MessageResource;
use App\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('status', '<>', 0)
        ->where('created_at', '>=', now()->subDay())
        ->orderBy('id', 'DESC')
        ->paginate();

        return MessageResource::collection($messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastSentMessages(Request $request)
    {
        $messages = Message::where('status', 0)
        ->orderBy('id', 'DESC')
        ->limit(50);

        $keyword = $request->get('q', null);
        if($keyword){

            if(strlen($keyword) < 3){
                return response()->json(['The search keyword length must be at least 3 char.'], 422);
            }

            $messages = $messages->where('phone_number', 'LIKE', '%' . $keyword . '%')
            ->orWhere('message', 'LIKE', '%' . $keyword . '%')
            ->orWhere('restaurant_name', 'LIKE', '%' . $keyword . '%');
        }

        $messages = $messages->get();

        return MessageResource::collection($messages);
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
