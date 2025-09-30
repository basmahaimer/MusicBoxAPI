<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Artist",
 *     type="object",
 *     title="Artist",
 *     required={"name","genre","country"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="genre", type="string"),
 *     @OA\Property(property="country", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Artist extends Model {
    use HasFactory;
    protected $fillable = ['name','genre','country'];

    public function albums() {
        return $this->hasMany(Album::class);
    }
}
