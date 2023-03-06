<?php

namespace App\Http\Controllers;

use App\Http\Data\StoreGameData;
use App\Http\Data\UpdateGameData;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = Game::filterable(request('filter', []))
            ->sortable(request('sort', []))
            ->paginate(5);

        return response()->json($games);
    }

    public function store(StoreGameData $request): JsonResponse
    {
        $game = Game::create(
            [
                ...$request->toArray(),
                'profile_id' => Auth::user()->profile_id
            ]
        );

        return response()->json($game, Response::HTTP_CREATED);
    }

    public function show(Game $game): JsonResponse
    {
        return response()->json($game);
    }

    public function update(UpdateGameData $request, Game $game): JsonResponse
    {
        $this->authorize('write', $game);

        $game = $game->fill($request->toArray());
        $game->save();
        return response()->json($game);
    }

    public function destroy(Game $game): JsonResponse
    {
        $this->authorize('write', $game);

        $game->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
