<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PlayerDao.php';

class PlayerService extends BaseService {
    public function __construct() {
        $dao = new PlayerDao();
        parent::__construct($dao);
    }

    public function createPlayer($data) {
        if (empty($data['first_name'])) {
            throw new Exception('First name is required.');
        }
        if (empty($data['last_name'])) {
            throw new Exception('Last name is required.');
        }
        if (empty($data['position'])) {
            throw new Exception('Position is required.');
        }
        if (empty($data['team_id'])) {
            throw new Exception('Team ID is required.');
        }

        $validPositions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];
        if (!in_array($data['position'], $validPositions)) {
            throw new Exception('Invalid position. Must be: Goalkeeper, Defender, Midfielder, or Forward.');
        }
        return $this->create($data);
    }

    public function updatePlayer($id, $data) {
        if (isset($data['position'])) {
            $validPositions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];
            if (!in_array($data['position'], $validPositions)) {
                throw new Exception('Invalid position. Must be: Goalkeeper, Defender, Midfielder, or Forward.');
            }
        }

        return $this->update($id, $data);
    }

    public function getByTeam($team_id) {
        return $this->dao->getByTeam($team_id);
    }

    public function getByNationality($nationality) {
        return $this->dao->getByNationality($nationality);
    }

    public function getByPosition($position) {
        $validPositions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];
        if (!in_array($position, $validPositions)) {
            throw new Exception('Invalid position.');
        }
        return $this->dao->getByPosition($position);
    }

    public function searchPlayers($searchTerm) {
        return $this->dao->search($searchTerm);
    }
}
?>