<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PlayerStatisticsDao.php';

class PlayerStatisticsService extends BaseService {
    public function __construct() {
        $dao = new PlayerStatisticsDao();
        parent::__construct($dao);
    }

    public function createPlayerStatistics($data) {
        if (empty($data['match_id'])) {
            throw new Exception('Match ID is required.');
        }
        if (empty($data['player_id'])) {
            throw new Exception('Player ID is required.');
        }
        if (empty($data['team_id'])) {
            throw new Exception('Team ID is required.');
        }

        $numericFields = ['goals', 'assists', 'yellow_cards', 'red_cards', 'passes', 'dribbles', 'tackles', 'saves'];
        foreach ($numericFields as $field) {
            if (isset($data[$field]) && $data[$field] < 0) {
                throw new Exception("$field cannot be negative.");
            }
        }

        $defaultValues = [
            'goals' => 0,
            'assists' => 0,
            'yellow_cards' => 0,
            'red_cards' => 0,
            'passes' => 0,
            'dribbles' => 0,
            'tackles' => 0,
            'saves' => 0
        ];

        foreach ($defaultValues as $field => $defaultValue) {
            if (!isset($data[$field])) {
                $data[$field] = $defaultValue;
            }
        }

        return $this->create($data);
    }

    public function updatePlayerStatistics($id, $data) {
        $numericFields = ['goals', 'assists', 'yellow_cards', 'red_cards', 'passes', 'dribbles', 'tackles', 'saves'];
        foreach ($numericFields as $field) {
            if (isset($data[$field]) && $data[$field] < 0) {
                throw new Exception("$field cannot be negative.");
            }
        }

        return $this->update($id, $data);
    }

    public function getByPlayer($player_id) {
        return $this->dao->getByPlayer($player_id);
    }

    public function getByMatch($match_id) {
        return $this->dao->getByMatch($match_id);
    }

    public function getByPlayerAndMatch($player_id, $match_id) {
        return $this->dao->getByPlayerAndMatch($player_id, $match_id);
    }

    public function getPlayerStatsSummary($player_id) {
        $stats = $this->dao->getByPlayer($player_id);
        
        $summary = [
            'total_matches' => count($stats),
            'total_goals' => 0,
            'total_assists' => 0,
            'total_yellow_cards' => 0,
            'total_red_cards' => 0,
            'total_passes' => 0,
            'total_dribbles' => 0,
            'total_tackles' => 0,
            'total_saves' => 0
        ];

        foreach ($stats as $stat) {
            $summary['total_goals'] += $stat['goals'];
            $summary['total_assists'] += $stat['assists'];
            $summary['total_yellow_cards'] += $stat['yellow_cards'];
            $summary['total_red_cards'] += $stat['red_cards'];
            $summary['total_passes'] += $stat['passes'];
            $summary['total_dribbles'] += $stat['dribbles'];
            $summary['total_tackles'] += $stat['tackles'];
            $summary['total_saves'] += $stat['saves'];
        }

        return $summary;
    }
}
?>