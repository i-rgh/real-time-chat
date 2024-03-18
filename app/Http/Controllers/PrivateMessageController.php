<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePrivateMessageRequest;
use App\Models\PrivateMessage;
use Illuminate\Http\Request;

class PrivateMessageController extends Controller
{
    public function send(CreatePrivateMessageRequest $request)
    {

        return PrivateMessage::create([
            'sender_id'   =>  auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'content'    => $request->content
        ]);
    }
}
