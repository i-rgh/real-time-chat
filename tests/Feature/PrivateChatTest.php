<?php

namespace Tests\Feature;

use App\Events\MessageSend;
use App\Http\Controllers\PrivateMessageController;
use App\Http\Requests\CreatePrivateMessageRequest;
use App\Models\PrivateMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PrivateChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_store_dispatch_event()
    {
        Event::fake();

        // Create sender and receiver users
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        // Acting as the sender user
        $this->actingAs($sender);

        // Mock the request data
        $requestData = [
            'receiver_id' => $receiver->id,
            'content' => 'Test message content'
        ];

        // Instantiate the controller and store the message
        $controller = new PrivateMessageController();
        $controller->store(new CreatePrivateMessageRequest($requestData));

        // Assert that the message was stored in the database
        $this->assertDatabaseHas('private_messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'content' => 'Test message content'
        ]);

        // Assert that the event was dispatched
        Event::assertDispatched(MessageSend::class, function ($event) use ($requestData) {
            return $event->message->receiver_id === $requestData['receiver_id'] &&
                $event->message->content === $requestData['content'];
        });
    }
}

