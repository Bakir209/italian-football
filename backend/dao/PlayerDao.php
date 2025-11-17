<?php
require_once 'BaseDao.php';

class PlayerDao extends BaseDao {
    public function __construct() {
        parent::__construct("players");
    }

    public function getByTeamId($team_id) {
        $stmt = $this->connection->prepare("SELECT * FROM players WHERE team_id = :team_id");
        $stmt->bindParam(':team_id', $team_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>