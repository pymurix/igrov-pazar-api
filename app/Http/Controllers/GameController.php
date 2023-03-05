<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function index(): JsonResponse
    {
        $games = Game::filterable(request('filter', []))
            ->sortable(request('sort', []))
            ->paginate(5);

        return response()->json($games);
    }

    public function store(StoreGameRequest $request): JsonResponse
    {
        $game = Game::create(
            array_merge(
                $request->validated(),
                ['user_id' => Auth::user()->id]
            )
        );

        return response()->json($game, Response::HTTP_CREATED);
    }

    public function show(Game $game): JsonResponse
    {
        return response()->json($game);
    }

    public function update(UpdateGameRequest $request, Game $game): JsonResponse
    {
        $this->authorize('write', $game);

        $game = $game->fill($request->validated());
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
