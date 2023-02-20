<?php

namespace App\Service;

use App\Entity\Team;
use App\Exception\UserNotFoundException;
use App\Model\TeamListResponse;
use App\Model\TeamModel;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;

class TeamService
{
    public function __construct(
        private TeamRepository $teamRepository,
        private UserRepository $userRepository, )
    {
    }

    public function getTeamsByUserId(int $userId): TeamListResponse
    {
        if (!$this->userRepository->existsById($userId)) {
            throw new UserNotFoundException();
        }

        $teams = $this->teamRepository->findTeamsByUserId($userId);

        return new TeamListResponse(array_map(
            [$this, 'map'],
            $teams
        ));
    }

    private function map(Team $team): TeamModel
    {
        return (new TeamModel())->setId($team->getId())
            ->setTitle($team->getTitle())
            ->setDescription($team->getDescription());
    }
}
