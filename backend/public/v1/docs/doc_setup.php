<?php
/**
 * @OA\Info(
 *     title="Sports Management API",
 *     description="A comprehensive API for managing sports teams, players, matches, and statistics",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="your-email@example.com",
 *         name="Sports API Team"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local Development Server"
 * )
 */

/**
 * @OA\Server(
 *     url="https://your-production-domain.com",
 *     description="Production Server"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

/**
 * @OA\Components(
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="username", type="string", example="john_doe"),
 *         @OA\Property(property="email", type="string", example="john@example.com"),
 *         @OA\Property(property="is_admin", type="boolean", example=false)
 *     ),
 *     @OA\Schema(
 *         schema="Player",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="first_name", type="string", example="Lionel"),
 *         @OA\Property(property="last_name", type="string", example="Messi"),
 *         @OA\Property(property="nationality", type="string", example="Argentinian"),
 *         @OA\Property(property="position", type="string", example="Forward"),
 *         @OA\Property(property="team_id", type="integer", example=1)
 *     ),
 *     @OA\Schema(
 *         schema="Team",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="FC Barcelona"),
 *         @OA\Property(property="city", type="string", example="Barcelona"),
 *         @OA\Property(property="stadium", type="string", example="Camp Nou")
 *     ),
 *     @OA\Schema(
 *         schema="Match",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="date", type="string", format="date-time", example="2024-01-15 20:00:00"),
 *         @OA\Property(property="home_team_id", type="integer", example=1),
 *         @OA\Property(property="away_team_id", type="integer", example=2),
 *         @OA\Property(property="home_score", type="integer", example=2),
 *         @OA\Property(property="away_score", type="integer", example=1)
 *     ),
 *     @OA\Schema(
 *         schema="PlayerStatistics",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="match_id", type="integer", example=1),
 *         @OA\Property(property="player_id", type="integer", example=1),
 *         @OA\Property(property="team_id", type="integer", example=1),
 *         @OA\Property(property="goals", type="integer", example=2),
 *         @OA\Property(property="assists", type="integer", example=1),
 *         @OA\Property(property="yellow_cards", type="integer", example=0),
 *         @OA\Property(property="red_cards", type="integer", example=0),
 *         @OA\Property(property="passes", type="integer", example=45),
 *         @OA\Property(property="dribbles", type="integer", example=12),
 *         @OA\Property(property="tackles", type="integer", example=3),
 *         @OA\Property(property="saves", type="integer", example=0)
 *     ),
 *     @OA\Schema(
 *         schema="Error",
 *         type="object",
 *         @OA\Property(property="error", type="string", example="Error message description")
 *     )
 * )
 */