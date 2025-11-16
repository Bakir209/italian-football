<?php
require_once 'vendor/autoload.php';

Flight::route('/docs', function() {
    Flight::redirect('/public/v1/docs/');
});

Flight::route('/api-docs', function() {
    Flight::redirect('/public/v1/docs/swagger.php');
});

Flight::before('start', function() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit(0);
    }
});

Flight::map('error', function(Exception $ex) {
    Flight::json(['error' => $ex->getMessage()], 500);
});

require_once 'services/UserService.php';
require_once 'services/PlayerService.php';
require_once 'services/TeamService.php';
require_once 'services/MatchService.php';
require_once 'services/PlayerStatisticsService.php';

Flight::register('userService', 'UserService');
Flight::register('playerService', 'PlayerService');
Flight::register('teamService', 'TeamService');
Flight::register('matchService', 'MatchService');
Flight::register('playerStatisticsService', 'PlayerStatisticsService');

require_once 'routes/UserRoutes.php';
require_once 'routes/PlayerRoutes.php';
require_once 'routes/TeamRoutes.php';
require_once 'routes/MatchRoutes.php';
require_once 'routes/PlayerStatisticsRoutes.php';

Flight::route('/', function() {
    echo json_encode([
        'message' => 'Sports Management API',
        'version' => '1.0',
        'endpoints' => [
            '/users' => 'User management',
            '/players' => 'Player management', 
            '/teams' => 'Team management',
            '/matches' => 'Match management',
            '/statistics' => 'Player statistics'
        ]
    ]);
});

Flight::start();
?>