<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\UserNotFoundException;
use App\Model\UserListResponse;
use App\Model\UserModel;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getUserById(int $userId): UserModel
    {
        if (!$this->userRepository->existsById($userId)) {
            throw new UserNotFoundException();
        }

        return $this->map($this->userRepository->getUserById($userId));
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
