<?php
/**
 * @OA\Tag(
 *     name="teams",
 *     description="Team management operations"
 * )
 */

/**
 * @OA\Get(
 *     path="/teams",
 *     tags={"teams"},
 *     summary="Get all teams",
 *     description="Retrieve a list of all teams",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Team")
 *         )
 *     )
 * )
 */
Flight::route('GET /teams', function() {
    try {
        $teams = Flight::teamService()->getAll();
        Flight::json($teams);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/teams/{id}",
 *     tags={"teams"},
 *     summary="Get team by ID",
 *     description="Retrieve a specific team by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Team ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Team found",
 *         @OA\JsonContent(ref="#/components/schemas/Team")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Team not found"
 *     )
 * )
 */
Flight::route('GET /teams/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid team ID'], 400);
            return;
        }
        
        $team = Flight::teamService()->getById($id);
        if ($team) {
            Flight::json($team);
        } else {
            Flight::json(['error' => 'Team not found'], 404);
        }
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/teams/{id}/players",
 *     tags={"teams"},
 *     summary="Get team with players",
 *     description="Retrieve a team along with all its players",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Team ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="FC Barcelona"),
 *             @OA\Property(property="city", type="string", example="Barcelona"),
 *             @OA\Property(property="stadium", type="string", example="Camp Nou"),
 *             @OA\Property(
 *                 property="players",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Player")
 *             )
 *         )
 *     )
 * )
 */
Flight::route('GET /teams/@id/players', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid team ID'], 400);
            return;
        }
        
        $teamWithPlayers = Flight::teamService()->getTeamWithPlayers($id);
        Flight::json($teamWithPlayers);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/teams",
 *     tags={"teams"},
 *     summary="Create a new team",
 *     description="Add a new team to the system",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Team data",
 *         @OA\JsonContent(
 *             required={"name", "city"},
 *             @OA\Property(property="name", type="string", example="FC Barcelona"),
 *             @OA\Property(property="city", type="string", example="Barcelona"),
 *             @OA\Property(property="stadium", type="string", example="Camp Nou")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Team created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Team created successfully"),
 *             @OA\Property(property="team_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error"
 *     )
 * )
 */
Flight::route('POST /teams', function() {
    try {
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $newTeam = Flight::teamService()->createTeam($data);
        Flight::json([
            'message' => 'Team created successfully',
            'team_id' => $newTeam['id']
        ], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/teams/{id}",
 *     tags={"teams"},
 *     summary="Update team",
 *     description="Update an existing team's information",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Team ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Team data to update",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Team Name"),
 *             @OA\Property(property="city", type="string", example="Updated City"),
 *             @OA\Property(property="stadium", type="string", example="Updated Stadium")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Team updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Team updated successfully"),
 *             @OA\Property(property="team", ref="#/components/schemas/Team")
 *         )
 *     )
 * )
 */
Flight::route('PUT /teams/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid team ID'], 400);
            return;
        }
        
        $data = Flight::request()->data->getData();
        
        if (empty($data)) {
            Flight::json(['error' => 'No data provided'], 400);
            return;
        }
        
        $updatedTeam = Flight::teamService()->updateTeam($id, $data);
        Flight::json([
            'message' => 'Team updated successfully',
            'team' => $updatedTeam
        ]);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/teams/{id}",
 *     tags={"teams"},
 *     summary="Delete team",
 *     description="Delete a team from the system",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Team ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Team deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Team deleted successfully")
 *         )
 *     )
 * )
 */
Flight::route('DELETE /teams/@id', function($id) {
    try {
        if (!is_numeric($id)) {
            Flight::json(['error' => 'Invalid team ID'], 400);
            return;
        }
        
        $team = Flight::teamService()->getById($id);
        if (!$team) {
            Flight::json(['error' => 'Team not found'], 404);
            return;
        }
        
        Flight::teamService()->delete($id);
        Flight::json(['message' => 'Team deleted successfully']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>