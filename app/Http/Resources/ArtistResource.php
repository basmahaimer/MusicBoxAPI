<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtistResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'genre' => $this->genre,
            'country' => $this->country,
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
        ];
    }
}
