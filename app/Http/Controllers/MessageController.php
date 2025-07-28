<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
class MessageController extends Controller
{


    public function send(Request $request)
    {
        $message = $request->message;

        broadcast(new MessageSent($request->message,auth()->id()));
        return response()->json(['status' => 'Message broadcasted!']);
    }
}
