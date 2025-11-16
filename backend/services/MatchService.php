<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/MatchDao.php';

class MatchService extends BaseService {
    public function __construct() {
        $dao = new MatchDao();
        parent::__construct($dao);
    }

    public function createMatch($data) {
        if (empty($data['date'])) {
            throw new Exception('Match date is required.');
        }
        if (empty($data['home_team_id'])) {
            throw new Exception('Home team ID is required.');
        }
        if (empty($data['away_team_id'])) {
            throw new Exception('Away team ID is required.');
        }

        if ($data['home_team_id'] == $data['away_team_id']) {
            throw new Exception('Home and away teams cannot be the same.');
        }

        $matchDate = new DateTime($data['date']);
        $currentDate = new DateTime();
        if ($matchDate < $currentDate) {
            throw new Exception('Match date cannot be in the past.');
        }

        if (!isset($data['home_score'])) {
            $data['home_score'] = null;
        }
        if (!isset($data['away_score'])) {
            $data['away_score'] = null;
        }

        return $this->create($data);
    }

    public function updateMatchScore($id, $home_score, $away_score) {
        if ($home_score < 0 || $away_score < 0) {
            throw new Exception('Scores cannot be negative.');
        }

        $data = [
            'home_score' => $home_score,
            'away_score' => $away_score
        ];

        return $this->update($id, $data);
    }

    public function getByTeam($team_id) {
        return $this->dao->getByTeam($team_id);
    }

    public function getByDateRange($start_date, $end_date) {
        if ($start_date > $end_date) {
            throw new Exception('Start date cannot be after end date.');
        }

        return $this->dao->getByDateRange($start_date, $end_date);
    }

    public function getCompletedMatches() {
        return $this->dao->getCompletedMatches();
    }

    public function getUpcomingMatches() {
        return $this->dao->getUpcomingMatches();
    }
}
?>