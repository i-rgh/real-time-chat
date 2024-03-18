<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function show()
    {
        return Inertia ::render('Chat/Chat', [ 'users' => \App\Models\User::with(['receiver', 'sender'])->get() ]);
    }
}
