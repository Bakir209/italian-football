<?php
require_once 'BaseDao.php';

class TeamDao extends BaseDao {
    public function __construct() {
        parent::__construct("teams");
    }

    public function getByCity($city) {
        $stmt = $this->connection->prepare("SELECT * FROM teams WHERE city = :city");
        $stmt->bindParam(':city', $city);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>