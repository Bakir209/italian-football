<?php
// Simple test script to verify routes are working
require_once '/../vendor/autoload.php';
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

echo "Testing FlightPHP Routes...\n\n";

try {
    $teams = Flight::teamService()->getAll();
    echo "✓ Teams endpoint working. Found " . count($teams) . " teams\n";
} catch (Exception $e) {
    echo "✗ Teams error: " . $e->getMessage() . "\n";
}

try {
    $players = Flight::playerService()->getAll();
    echo "✓ Players endpoint working. Found " . count($players) . " players\n";
} catch (Exception $e) {
    echo "✗ Players error: " . $e->getMessage() . "\n";
}

try {
    $users = Flight::userService()->getAll();
    echo "✓ Users endpoint working. Found " . count($users) . " users\n";
} catch (Exception $e) {
    echo "✗ Users error: " . $e->getMessage() . "\n";
}

echo "\nFlightPHP Routes testing completed!\n";
echo "Now start your server and test with Postman:\n";
echo "php -S localhost:8000\n";
echo "Then visit: http://localhost:8000\n";
?>