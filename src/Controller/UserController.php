<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\ErrorResponse;

class UserController extends AbstractController
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="return members for team",
     *
     *     @Model(type=UserModel::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Not found team",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/team/{id}/members', methods: ['GET'])]
    public function getUserById(int $id): Response
    {
        return $this->json($this->userService->getUserById($id));
    }
}
