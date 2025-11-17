<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/TeamDao.php';

class TeamService extends BaseService {
    public function __construct() {
        $dao = new TeamDao();
        parent::__construct($dao);
    }

    public function createTeam($data) {
        if (empty($data['name'])) {
            throw new Exception('Team name is required.');
        }
        if (empty($data['city'])) {
            throw new Exception('City is required.');
        }

        $existingTeam = $this->dao->getByName($data['name']);
        if ($existingTeam) {
            throw new Exception('Team name already exists.');
        }

        return $this->create($data);
    }

    public function updateTeam($id, $data) {
        if (isset($data['name'])) {
            $existingTeam = $this->dao->getByName($data['name']);
            if ($existingTeam && $existingTeam['id'] != $id) {
                throw new Exception('Team name already exists.');
            }
        }

        return $this->update($id, $data);
    }

    public function getByName($name) {
        return $this->dao->getByName($name);
    }

    public function getByCity($city) {
        return $this->dao->getByCity($city);
    }

    public function getTeamWithPlayers($team_id) {
        $team = $this->getById($team_id);
        if (!$team) {
            throw new Exception('Team not found.');
        }
        
        $playerService = new PlayerService();
        $team['players'] = $playerService->getByTeam($team_id);
        
        return $team;
    }
}
?>