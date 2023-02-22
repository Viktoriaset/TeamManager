<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Service\GroupService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\GroupListResponse;

class GroupController extends AbstractController
{
    public function __construct(private GroupService $groupService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="return Teams by user Id",
     *
     *     @Model(type=GroupListResponse::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Not found User",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/user/{userId}/teams', methods: ['GET'])]
    public function getTeamsByUsersId(int $userId): Response
    {
        return $this->json($this->groupService->getGroupsByUserId($userId));
    }
}
