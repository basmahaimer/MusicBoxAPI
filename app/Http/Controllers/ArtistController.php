<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Artists",
 *     description="API Endpoints for managing artists"
 * )
 */
class ArtistController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/artists",
     *     tags={"Artists"},
     *     summary="Get list of artists with pagination and filters",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter by artist name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="genre",
     *         in="query",
     *         description="Filter by genre (comma-separated for multiple)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="country",
     *         in="query",
     *         description="Filter by country",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of artists",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Artist"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $artists = Artist::with('albums.songs')
            ->when($request->name, fn($q) => $q->where('name', 'like', "%{$request->name}%"))
            ->when($request->genre, function($q) use ($request) {
                $genres = explode(',', $request->genre);
                $q->whereIn('genre', $genres);
            })
            ->when($request->country, fn($q) => $q->where('country', 'like', "%{$request->country}%"))
            ->paginate($request->per_page ?? 10);

        return ArtistResource::collection($artists);
    }

    /**
     * @OA\Post(
     *     path="/api/artists",
     *     tags={"Artists"},
     *     summary="Create a new artist",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Artist")
     *     ),
     *     @OA\Response(response=201, description="Artist created successfully")
     * )
     */
    public function store(StoreArtistRequest $request)
    {
        $artist = Artist::create($request->validated());
        return (new ArtistResource($artist->load('albums.songs')))->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/artists/{id}",
     *     tags={"Artists"},
     *     summary="Get artist details by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Artist details")
     * )
     */
    public function show(Artist $artist)
    {
        $artist->load('albums.songs');
        return new ArtistResource($artist);
    }

    /**
     * @OA\Put(
     *     path="/api/artists/{id}",
     *     tags={"Artists"},
     *     summary="Update an existing artist",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Artist")
     *     ),
     *     @OA\Response(response=200, description="Artist updated successfully")
     * )
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        $artist->update($request->validated());
        return new ArtistResource($artist->load('albums.songs'));
    }

    /**
     * @OA\Delete(
     *     path="/api/artists/{id}",
     *     tags={"Artists"},
     *     summary="Delete an artist",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Artist deleted")
     * )
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();
        return response()->json(null, 204);
    }
}
