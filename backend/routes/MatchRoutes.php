<?php
/**
 * @OA\Tag(
 *     name="matches",
 *     description="Match management operations"
 * )
 */

/**
 * @OA\Get(
 *     path="/matches",
 *     tags={"matches"},
 *     summary="Get all matches",
 *     description="Retrieve a list of all matches",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Match")
 *         )
 *     )
 * )
 */
Flight::route('GET /matches', function() {
    try {
        $matches = Flight::matchService()->getAll();
        Flight::json($matches);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/matches/{id}",
 *     tags={"matches"},
 *     summary="Get match by ID",
 *     description="Retrieve a specific match by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Match ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Match found",
 *         @OA\JsonContent(ref="#/components/schemas/Match")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Match not found"
 *     )
 * )
 */
Flight::route('GET /matches/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid match ID'], 400);
            return;
        }
        
        $match = Flight::matchService()->getById($id);
        if ($match) {
            Flight::json($match);
        } else {
            Flight::json(['error' => 'Match not found'], 404);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/matches/team/{team_id}",
 *     tags={"matches"},
 *     summary="Get matches by team",
 *     description="Retrieve all matches for a specific team",
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
 *             @OA\Items(ref="#/components/schemas/Match")
 *         )
 *     )
 * )
 */
Flight::route('GET /matches/team/@team_id', function($team_id) {
    try {
        if (!is_numeric($team_id)) {
            Flight::json(['error' => 'Invalid team ID'], 400);
            return;
        }
        
        $matches = Flight::matchService()->getByTeam($team_id);
        Flight::json($matches);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/matches/completed",
 *     tags={"matches"},
 *     summary="Get completed matches",
 *     description="Retrieve all matches that have been completed (have scores)",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Match")
 *         )
 *     )
 * )
 */
Flight::route('GET /matches/completed', function() {
    try {
        $matches = Flight::matchService()->getCompletedMatches();
        Flight::json($matches);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/matches/upcoming",
 *     tags={"matches"},
 *     summary="Get upcoming matches",
 *     description="Retrieve all upcoming matches (future dates with no scores)",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Match")
 *         )
 *     )
 * )
 */
Flight::route('GET /matches/upcoming', function() {
    try {
        $matches = Flight::matchService()->getUpcomingMatches();
        Flight::json($matches);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/matches",
 *     tags={"matches"},
 *     summary="Create a new match",
 *     description="Schedule a new match",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Match data",
 *         @OA\JsonContent(
 *             required={"date", "home_team_id", "away_team_id"},
 *             @OA\Property(property="date", type="string", format="date-time", example="2024-01-15 20:00:00"),
 *             @OA\Property(property="home_team_id", type="integer", example=1),
 *             @OA\Property(property="away_team_id", type="integer", example=2),
 *             @OA\Property(property="home_score", type="integer", example=null),
 *             @OA\Property(property="away_score", type="integer", example=null)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Match created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Match created successfully"),
 *             @OA\Property(property="match_id", type="integer", example=1)
 *         )
 *     )
 * )
 */
Flight::route('POST /matches', function() {
    try {
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $newMatch = Flight::matchService()->createMatch($data);
        Flight::json([
            'message' => 'Match created successfully',
            'match_id' => $newMatch['id']
        ], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/matches/{id}",
 *     tags={"matches"},
 *     summary="Update match",
 *     description="Update match information",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Match ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Match data to update",
 *         @OA\JsonContent(
 *             @OA\Property(property="date", type="string", format="date-time", example="2024-01-15 21:00:00"),
 *             @OA\Property(property="home_team_id", type="integer", example=1),
 *             @OA\Property(property="away_team_id", type="integer", example=2),
 *             @OA\Property(property="home_score", type="integer", example=2),
 *             @OA\Property(property="away_score", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Match updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Match updated successfully"),
 *             @OA\Property(property="match", ref="#/components/schemas/Match")
 *         )
 *     )
 * )
 */
Flight::route('PUT /matches/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid match ID'], 400);
            return;
        }
        
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $updatedMatch = Flight::matchService()->update($id, $data);
        Flight::json([
            'message' => 'Match updated successfully',
            'match' => $updatedMatch
        ]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Patch(
 *     path="/matches/{id}/score",
 *     tags={"matches"},
 *     summary="Update match score",
 *     description="Update only the score of a match",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Match ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Score data",
 *         @OA\JsonContent(
 *             required={"home_score", "away_score"},
 *             @OA\Property(property="home_score", type="integer", example=2),
 *             @OA\Property(property="away_score", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Match score updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Match score updated successfully"),
 *             @OA\Property(property="match", ref="#/components/schemas/Match")
 *         )
 *     )
 * )
 */
Flight::route('PATCH /matches/@id/score', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid match ID'], 400);
            return;
        }
        
        $data = Flight::request()->data->getData();
        
        if (!isset($data['home_score']) || !isset($data['away_score'])) {
            Flight::json(['error' => 'Both home_score and away_score are required'], 400);
            return;
        }
        
        $updatedMatch = Flight::matchService()->updateMatchScore($id, $data['home_score'], $data['away_score']);
        Flight::json([
            'message' => 'Match score updated successfully',
            'match' => $updatedMatch
        ]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/matches/{id}",
 *     tags={"matches"},
 *     summary="Delete match",
 *     description="Delete a match from the system",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Match ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Match deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Match deleted successfully")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /matches/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid match ID'], 400);
            return;
        }
        
        $match = Flight::matchService()->getById($id);
        if (!$match) {
            Flight::json(['error' => 'Match not found'], 404);
            return;
        }
        
        Flight::matchService()->delete($id);
        Flight::json(['message' => 'Match deleted successfully']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>