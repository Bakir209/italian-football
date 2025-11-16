<?php
/**
 * @OA\Tag(
 *     name="players",
 *     description="Player management operations"
 * )
 */

/**
 * @OA\Get(
 *     path="/players",
 *     tags={"players"},
 *     summary="Get all players",
 *     description="Retrieve a list of all players",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Player")
 *         )
 *     )
 * )
 */
Flight::route('GET /players', function() {
    try {
        $players = Flight::playerService()->getAll();
        Flight::json($players);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/players/{id}",
 *     tags={"players"},
 *     summary="Get player by ID",
 *     description="Retrieve a specific player by their ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Player ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Player found",
 *         @OA\JsonContent(ref="#/components/schemas/Player")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Player not found"
 *     )
 * )
 */
Flight::route('GET /players/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid player ID'], 400);
            return;
        }
        
        $player = Flight::playerService()->getById($id);
        if ($player) {
            Flight::json($player);
        } else {
            Flight::json(['error' => 'Player not found'], 404);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/players/team/{team_id}",
 *     tags={"players"},
 *     summary="Get players by team",
 *     description="Retrieve all players belonging to a specific team",
 *     @OA\Parameter(
 *         name="team_id",
 *         in="path",
 *         required=true,
 *         description="Team ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Player")
 *         )
 *     )
 * )
 */
Flight::route('GET /players/team/@team_id', function($team_id) {
    try {
        if (!is_numeric($team_id)) {
            Flight::json(['error' => 'Invalid team ID'], 400);
            return;
        }
        
        $players = Flight::playerService()->getByTeam($team_id);
        Flight::json($players);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/players",
 *     tags={"players"},
 *     summary="Create a new player",
 *     description="Add a new player to the system",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Player data",
 *         @OA\JsonContent(
 *             required={"first_name", "last_name", "position", "team_id"},
 *             @OA\Property(property="first_name", type="string", example="Lionel"),
 *             @OA\Property(property="last_name", type="string", example="Messi"),
 *             @OA\Property(property="nationality", type="string", example="Argentinian"),
 *             @OA\Property(property="position", type="string", example="Forward", enum={"Goalkeeper", "Defender", "Midfielder", "Forward"}),
 *             @OA\Property(property="team_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Player created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Player created successfully"),
 *             @OA\Property(property="player_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     )
 * )
 */
Flight::route('POST /players', function() {
    try {
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $newPlayer = Flight::playerService()->createPlayer($data);
        Flight::json([
            'message' => 'Player created successfully',
            'player_id' => $newPlayer['id']
        ], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

?>