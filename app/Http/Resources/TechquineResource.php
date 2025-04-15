<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechquineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'technique' => $this->technique,
            'power' => $this->power,
            'category_id' => $this->category_id,
            'categories' => $this->category
        ];
    }
}
