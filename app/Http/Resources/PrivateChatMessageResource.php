<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'         => $this->id,
            'content'    => $this->content,
            'receiver_id' => $this->receiver_id,
            'sender_id'   => $this->sender_id,
            'sender'   => [
                'id'   => $this->sender->id,
                'name' => $this->sender->name
            ]
        ];
    }
}
