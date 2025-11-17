<?php
require_once 'services/UserService.php';
require_once 'services/PlayerService.php';
require_once 'services/TeamService.php';
require_once 'services/MatchService.php';
require_once 'services/PlayerStatisticsService.php';

echo "Testing Business Logic Layer...\n\n";

echo "=== Testing UserService ===\n";
try {
    $userService = new UserService();
    
    $users = $userService->getAll();
    echo "Total users: " . count($users) . "\n";
    
    if (!empty($users)) {
        $firstUser = $userService->getById($users[0]['id']);
        echo "First user: " . $firstUser['username'] . "\n";
    }
    
} catch (Exception $e) {
    echo "UserService Error: " . $e->getMessage() . "\n";
}

echo "\n=== Testing PlayerService ===\n";
try {
    $playerService = new PlayerService();
    
    $players = $playerService->getAll();
    echo "Total players: " . count($players) . "\n";
    
    if (!empty($players)) {
        $teamPlayers = $playerService->getByTeam($players[0]['team_id']);
        echo "Players in team " . $players[0]['team_id'] . ": " . count($teamPlayers) . "\n";
    }
    
} catch (Exception $e) {
    echo "PlayerService Error: " . $e->getMessage() . "\n";
}

echo "\n=== Testing TeamService ===\n";
try {
    $teamService = new TeamService();
    
    $teams = $teamService->getAll();
    echo "Total teams: " . count($teams) . "\n";
    
} catch (Exception $e) {
    echo "TeamService Error: " . $e->getMessage() . "\n";
}

echo "\nBusiness Logic Layer testing completed!\n";
?>