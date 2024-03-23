<?php

namespace App\Http\Controllers;

use App\Events\ChatRoomMessageSend;
use App\Http\Requests\CreateChatRoomMessageRequest;
use App\Http\Resources\ChatRoomMessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    public function store(CreateChatRoomMessageRequest $request): \Illuminate\Http\RedirectResponse
    {
        $message =  Message::create([
            ...$request->all(),
            'user_id' => auth()->id(),
        ]);


        event(new ChatRoomMessageSend(new ChatRoomMessageResource($message)));
        return Redirect::route('chat-room.index');
    }
}
