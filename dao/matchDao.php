<?php
require_once 'BaseDao.php';

class MatchDao extends BaseDao {
    public function __construct() {
        parent::__construct("matches");
    }

    public function getByDate($date) {
        $stmt = $this->connection->prepare("SELECT * FROM matches WHERE date = :date");
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>