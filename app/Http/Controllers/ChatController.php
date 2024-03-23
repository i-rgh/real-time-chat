<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrivateChatResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ChatController extends Controller
{
    public function show()
    {

        $data = PrivateChatResource::collection(User::getUsersExpectMe());

        return Inertia::render('Chat/Chat', [ 'users' => $data->collection  ]);
    }
}
