<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/albums",
     *     tags={"Albums"},
     *     summary="Lister les albums",
     *     description="Retourne la liste des albums avec pagination et filtres optionnels",
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Filtrer par titre de l'album",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="artist",
     *         in="query",
     *         description="Filtrer par nom d'artiste",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         description="Filtrer par année",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Nombre d'éléments par page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste paginée d'albums",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Album"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $albums = Album::with('artist', 'songs')
            ->when($request->title, fn($q) => $q->where('title', 'like', "%{$request->title}%"))
            ->when($request->artist, fn($q) => $q->whereHas('artist', fn($q2) => $q2->where('name', 'like', "%{$request->artist}%")))
            ->when($request->year, fn($q) => $q->where('year', $request->year))
            ->paginate($request->per_page ?? 10);

        return AlbumResource::collection($albums);
    }

    /**
     * @OA\Post(
     *     path="/api/albums",
     *     tags={"Albums"},
     *     summary="Créer un album",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Album")
     *     ),
     *     @OA\Response(response=201, description="Album créé avec succès")
     * )
     */
    public function store(StoreAlbumRequest $request)
    {
        $album = Album::create($request->validated());
        return (new AlbumResource($album->load('artist', 'songs')))->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/albums/{album}",
     *     tags={"Albums"},
     *     summary="Voir un album",
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         description="ID de l'album",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Détail d'un album")
     * )
     */
    public function show(Album $album)
    {
        $album->load('artist', 'songs');
        return new AlbumResource($album);
    }

    /**
     * @OA\Put(
     *     path="/api/albums/{album}",
     *     tags={"Albums"},
     *     summary="Mettre à jour un album",
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/Album")),
     *     @OA\Response(response=200, description="Album mis à jour")
     * )
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $album->update($request->validated());
        return new AlbumResource($album->load('artist', 'songs'));
    }

    /**
     * @OA\Delete(
     *     path="/api/albums/{album}",
     *     tags={"Albums"},
     *     summary="Supprimer un album",
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Album supprimé")
     * )
     */
    public function destroy(Album $album)
    {
        $album->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/albums/{album}/songs",
     *     tags={"Albums"},
     *     summary="Lister les chansons d'un album",
     *     @OA\Parameter(
     *         name="album",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Chansons de l'album")
     * )
     */
    public function songs(Album $album)
    {
        return response()->json($album->songs()->get());
    }
}

