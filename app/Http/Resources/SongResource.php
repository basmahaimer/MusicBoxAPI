<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'duration' => $this->duration,
            'album' => new AlbumResource($this->whenLoaded('album')),
        ];
    }
}
