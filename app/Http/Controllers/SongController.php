<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Http\Resources\SongResource;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/songs",
     *     tags={"Songs"},
     *     summary="Liste des chansons",
     *     @OA\Parameter(name="title", in="query", @OA\Schema(type="string"), description="Filtrer par titre"),
     *     @OA\Parameter(name="artist", in="query", @OA\Schema(type="string"), description="Filtrer par artiste"),
     *     @OA\Parameter(name="album", in="query", @OA\Schema(type="string"), description="Filtrer par album"),
     *     @OA\Parameter(name="min_duration", in="query", @OA\Schema(type="integer"), description="Durée minimale en secondes"),
     *     @OA\Parameter(name="max_duration", in="query", @OA\Schema(type="integer"), description="Durée maximale en secondes"),
     *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer", default=10), description="Nombre d'éléments par page"),
     *     @OA\Response(
     *         response=200,
     *         description="Liste de chansons",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Song"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $songs = Song::with('album.artist')
            ->when($request->title, fn($q) => $q->where('title', 'like', "%{$request->title}%"))
            ->when($request->artist, fn($q) => $q->whereHas('album.artist', fn($q2) => $q2->where('name', 'like', "%{$request->artist}%")))
            ->when($request->album, fn($q) => $q->whereHas('album', fn($q2) => $q2->where('title', 'like', "%{$request->album}%")))
            ->when($request->min_duration, fn($q) => $q->where('duration', '>=', $request->min_duration))
            ->when($request->max_duration, fn($q) => $q->where('duration', '<=', $request->max_duration))
            ->paginate($request->per_page ?? 10);

        return SongResource::collection($songs);
    }

    /**
     * @OA\Post(
     *     path="/api/songs",
     *     tags={"Songs"},
     *     summary="Créer une chanson",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Chanson créée",
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     )
     * )
     */
    public function store(StoreSongRequest $request)
    {
        $song = Song::create($request->validated());
        return (new SongResource($song->load('album.artist')))->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/songs/{song}",
     *     tags={"Songs"},
     *     summary="Détail d'une chanson",
     *     @OA\Parameter(name="song", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Détails de la chanson",
     *         @OA\JsonContent(ref="#/components/schemas/Song")
     *     )
     * )
     */
    public function show(Song $song)
    {
        $song->load('album.artist');
        return new SongResource($song);
    }

    /**
     * @OA\Put(
     *     path="/api/songs/{song}",
     *     tags={"Songs"},
     *     summary="Mettre à jour une chanson",
     *     @OA\Parameter(name="song", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/Song")),
     *     @OA\Response(response=200, description="Chanson mise à jour")
     * )
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        $song->update($request->validated());
        return new SongResource($song->load('album.artist'));
    }

    /**
     * @OA\Delete(
     *     path="/api/songs/{song}",
     *     tags={"Songs"},
     *     summary="Supprimer une chanson",
     *     @OA\Parameter(name="song", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Chanson supprimée")
     * )
     */
    public function destroy(Song $song)
    {
        $song->delete();
        return response()->json(null, 204);
    }
}
