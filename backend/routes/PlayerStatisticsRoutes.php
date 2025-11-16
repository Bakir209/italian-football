<?php
/**
 * @OA\Tag(
 *     name="statistics",
 *     description="Player statistics operations"
 * )
 */

/**
 * @OA\Get(
 *     path="/statistics",
 *     tags={"statistics"},
 *     summary="Get all statistics",
 *     description="Retrieve a list of all player statistics",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/PlayerStatistics")
 *         )
 *     )
 * )
 */
Flight::route('GET /statistics', function() {
    try {
        $stats = Flight::playerStatisticsService()->getAll();
        Flight::json($stats);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/statistics/{id}",
 *     tags={"statistics"},
 *     summary="Get statistics by ID",
 *     description="Retrieve specific player statistics by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Statistics ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Statistics found",
 *         @OA\JsonContent(ref="#/components/schemas/PlayerStatistics")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Statistics not found"
 *     )
 * )
 */
Flight::route('GET /statistics/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid statistics ID'], 400);
            return;
        }
        
        $stats = Flight::playerStatisticsService()->getById($id);
        if ($stats) {
            Flight::json($stats);
        } else {
            Flight::json(['error' => 'Statistics not found'], 404);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/statistics/player/{player_id}",
 *     tags={"statistics"},
 *     summary="Get statistics by player",
 *     description="Retrieve all statistics for a specific player",
 *     @OA\Parameter(
 *         name="player_id",
 *         in="path",
 *         required=true,
 *         description="Player ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/PlayerStatistics")
 *         )
 *     )
 * )
 */
Flight::route('GET /statistics/player/@player_id', function($player_id) {
    try {
        if (!is_numeric($player_id)) {
            Flight::json(['error' => 'Invalid player ID'], 400);
            return;
        }
        
        $stats = Flight::playerStatisticsService()->getByPlayer($player_id);
        Flight::json($stats);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/statistics/match/{match_id}",
 *     tags={"statistics"},
 *     summary="Get statistics by match",
 *     description="Retrieve all statistics for a specific match",
 *     @OA\Parameter(
 *         name="match_id",
 *         in="path",
 *         required=true,
 *         description="Match ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/PlayerStatistics")
 *         )
 *     )
 * )
 */
Flight::route('GET /statistics/match/@match_id', function($match_id) {
    try {
        if (!is_numeric($match_id)) {
            Flight::json(['error' => 'Invalid match ID'], 400);
            return;
        }
        
        $stats = Flight::playerStatisticsService()->getByMatch($match_id);
        Flight::json($stats);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/statistics/player/{player_id}/summary",
 *     tags={"statistics"},
 *     summary="Get player statistics summary",
 *     description="Retrieve a summary of all statistics for a player",
 *     @OA\Parameter(
 *         name="player_id",
 *         in="path",
 *         required=true,
 *         description="Player ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="total_matches", type="integer", example=15),
 *             @OA\Property(property="total_goals", type="integer", example=12),
 *             @OA\Property(property="total_assists", type="integer", example=8),
 *             @OA\Property(property="total_yellow_cards", type="integer", example=2),
 *             @OA\Property(property="total_red_cards", type="integer", example=0),
 *             @OA\Property(property="total_passes", type="integer", example=450),
 *             @OA\Property(property="total_dribbles", type="integer", example=85),
 *             @OA\Property(property="total_tackles", type="integer", example=25),
 *             @OA\Property(property="total_saves", type="integer", example=0)
 *         )
 *     )
 * )
 */
Flight::route('GET /statistics/player/@player_id/summary', function($player_id) {
    try {
        if (!is_numeric($player_id)) {
            Flight::json(['error' => 'Invalid player ID'], 400);
            return;
        }
        
        $summary = Flight::playerStatisticsService()->getPlayerStatsSummary($player_id);
        Flight::json($summary);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/statistics",
 *     tags={"statistics"},
 *     summary="Create new player statistics",
 *     description="Add statistics for a player in a specific match",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Statistics data",
 *         @OA\JsonContent(
 *             required={"match_id", "player_id", "team_id"},
 *             @OA\Property(property="match_id", type="integer", example=1),
 *             @OA\Property(property="player_id", type="integer", example=1),
 *             @OA\Property(property="team_id", type="integer", example=1),
 *             @OA\Property(property="goals", type="integer", example=2),
 *             @OA\Property(property="assists", type="integer", example=1),
 *             @OA\Property(property="yellow_cards", type="integer", example=0),
 *             @OA\Property(property="red_cards", type="integer", example=0),
 *             @OA\Property(property="passes", type="integer", example=45),
 *             @OA\Property(property="dribbles", type="integer", example=12),
 *             @OA\Property(property="tackles", type="integer", example=3),
 *             @OA\Property(property="saves", type="integer", example=0)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Statistics created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Player statistics created successfully"),
 *             @OA\Property(property="statistics_id", type="integer", example=1)
 *         )
 *     )
 * )
 */
Flight::route('POST /statistics', function() {
    try {
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $newStats = Flight::playerStatisticsService()->createPlayerStatistics($data);
        Flight::json([
            'message' => 'Player statistics created successfully',
            'statistics_id' => $newStats['id']
        ], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/statistics/{id}",
 *     tags={"statistics"},
 *     summary="Update player statistics",
 *     description="Update existing player statistics",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Statistics ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Statistics data to update",
 *         @OA\JsonContent(
 *             @OA\Property(property="goals", type="integer", example=3),
 *             @OA\Property(property="assists", type="integer", example=2),
 *             @OA\Property(property="yellow_cards", type="integer", example=1),
 *             @OA\Property(property="red_cards", type="integer", example=0),
 *             @OA\Property(property="passes", type="integer", example=50),
 *             @OA\Property(property="dribbles", type="integer", example=15),
 *             @OA\Property(property="tackles", type="integer", example=4),
 *             @OA\Property(property="saves", type="integer", example=0)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Statistics updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Player statistics updated successfully"),
 *             @OA\Property(property="statistics", ref="#/components/schemas/PlayerStatistics")
 *         )
 *     )
 * )
 */
Flight::route('PUT /statistics/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid statistics ID'], 400);
            return;
        }
        
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $updatedStats = Flight::playerStatisticsService()->updatePlayerStatistics($id, $data);
        Flight::json([
            'message' => 'Player statistics updated successfully',
            'statistics' => $updatedStats
        ]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/statistics/{id}",
 *     tags={"statistics"},
 *     summary="Delete player statistics",
 *     description="Delete player statistics record",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Statistics ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Statistics deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Player statistics deleted successfully")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /statistics/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid statistics ID'], 400);
            return;
        }
        
        $stats = Flight::playerStatisticsService()->getById($id);
        if (!$stats) {
            Flight::json(['error' => 'Statistics not found'], 404);
            return;
        }
        
        Flight::playerStatisticsService()->delete($id);
        Flight::json(['message' => 'Player statistics deleted successfully']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>