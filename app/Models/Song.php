<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Song",
 *     type="object",
 *     title="Song",
 *     required={"title","duration","album_id"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="duration", type="integer"),
 *     @OA\Property(property="album_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Song extends Model {
    use HasFactory;
    protected $fillable = ['title','duration','album_id'];

    public function album() {
        return $this->belongsTo(Album::class);
    }
}
