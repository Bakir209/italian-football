<?php
require_once 'BaseDao.php';

class PlayerStatisticsDao extends BaseDao {
    public function __construct() {
        parent::__construct("playerStatistics");
    }

    public function getByPlayerId($player_id) {
        $stmt = $this->connection->prepare("SELECT * FROM playerStatistics WHERE player_id = :player_id");
        $stmt->bindParam(':player_id', $player_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>