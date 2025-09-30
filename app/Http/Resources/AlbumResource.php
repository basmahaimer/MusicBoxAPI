<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'artist' => new ArtistResource($this->whenLoaded('artist')),
            'songs' => SongResource::collection($this->whenLoaded('songs')),
        ];
    }
}
