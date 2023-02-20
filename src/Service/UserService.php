<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\TeamNotFoundException;
use App\Model\UserListResponse;
use App\Model\UserModel;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private TeamRepository $teamRepository)
    {
    }

    public function getUsersByTeamId(int $teamId): UserListResponse
    {
        if (!$this->teamRepository->existsById($teamId)) {
            throw new TeamNotFoundException();
        }

        $users = $this->userRepository->getUsersByTeamId($teamId);

        return new UserListResponse(array_map(
            [$this, 'map'],
            $users
        ));
    }

    private function map(User $user): UserModel
    {
        return (new UserModel())
            ->setId($user->getId())
            ->setFirstName($user->getFirstName())
            ->setSecondName($user->getSecondName())
            ->setPatronymic($user->getPatronymic());
    }
}
