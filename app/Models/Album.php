<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Album",
 *     type="object",
 *     title="Album",
 *     required={"title","year","artist_id"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="year", type="integer"),
 *     @OA\Property(property="artist_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Album extends Model {
    use HasFactory;
    protected $fillable = ['title','year','artist_id'];

    public function artist() {
        return $this->belongsTo(Artist::class);
    }

    public function songs() {
        return $this->hasMany(Song::class);
    }
}
