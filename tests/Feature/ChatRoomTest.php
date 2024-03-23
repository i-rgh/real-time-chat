<?php

namespace Tests\Feature;

use App\Http\Resources\ChatRoomsResource;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatRoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_room_index_displays_list_of_rooms(): void
    {
        Room::factory()->count(3)->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('chat-room.index'));

        $rooms = ChatRoomsResource::collection( Room::all());

        $response->assertOk();
    }

    public function test_user_can_create_a_chat_room(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('chat-room.store'), [
            'name' => 'Test Room',
        ]);

        $this->assertCount(1, Room::all());
        $this->assertDatabaseHas('rooms', ['name' => 'Test Room']);


    }

}
