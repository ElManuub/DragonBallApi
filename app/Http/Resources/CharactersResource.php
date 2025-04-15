<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class CharactersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'breed' => $this->breed,
            'power' => $this->power,
            'character_type' => $this->character_type,
            'techniques' => TechquineResource::collection($this->techniques)
        ];
    }
}
