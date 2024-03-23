<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChatRoomRequest;
use App\Http\Resources\ChatRoomsResource;
use App\Models\Room;
use App\Models\UserChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $rooms = ChatRoomsResource::collection( Room::all());

        return Inertia::render('Room/Room' , [
            'rooms' => $rooms->collection,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateChatRoomRequest $request): \Illuminate\Http\RedirectResponse
    {
        $room = Room::create($request->all());
        $room->users()->attach([
            'user_id' => auth()->id()
        ]);
        return Redirect::route('chat-room.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
