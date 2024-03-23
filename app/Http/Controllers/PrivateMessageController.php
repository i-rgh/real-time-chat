<?php

namespace App\Http\Controllers;

use App\Events\MessageSend;
use App\Http\Requests\CreatePrivateMessageRequest;
use App\Http\Resources\PrivateChatMessageResource;
use App\Http\Resources\PrivateChatResource;
use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PrivateMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePrivateMessageRequest $request): RedirectResponse
    {


        $message = PrivateMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' =>  $request->receiver_id,
            'content'     => $request->content
        ]);


        $message->load('sender');


        event(new MessageSend(new PrivateChatMessageResource($message)));

        return Redirect::route('chat');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
