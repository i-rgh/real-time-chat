<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('MessageSend.{receiverId}', function ($user,   $receiverId) {
    return $user->id == $receiverId;
});

Broadcast::channel('chat-room.{chatRoomId}', function ($user,   $chatRoomId) {
   return true;
});
