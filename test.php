<?php
require_once 'dao/userDao.php';
require_once 'dao/teamDao.php';
require_once 'dao/playerDao.php';
require_once 'dao/matchDao.php';
require_once 'dao/playerStatisticsDao.php';

// Instantiate DAO objects
$userDao = new UserDao();
$teamDao = new TeamDao();
$playerDao = new PlayerDao();
$matchDao = new MatchDao();
$statsDao = new PlayerStatisticsDao();

// TEST: Fetch all records
echo "<h3>Users</h3>";
print_r($userDao->getAll());

echo "<h3>Teams</h3>";
print_r($teamDao->getAll());

echo "<h3>Players</h3>";
print_r($playerDao->getAll());

echo "<h3>Matches</h3>";
print_r($matchDao->getAll());

echo "<h3>Player Statistics</h3>";
print_r($statsDao->getAll());
?>