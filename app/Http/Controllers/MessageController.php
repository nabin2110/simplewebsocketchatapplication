<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageEvent;

class MessageController extends Controller
{
    public function sendMessage(Request $request){
        $message_created = Message::create($request->all());
        broadcast(new MessageEvent($message_created));
        return response()->json(['message'=>$message_created]);
    }
}
