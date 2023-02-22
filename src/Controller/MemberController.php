<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Model\MemberListResponse;
use App\Service\MemberService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    public function __construct(private MemberService $memberService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="Return members for group",
     *
     *     @Model(type=MemberListResponse::class))
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Group not found",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/group/{groupId}/members', methods: ['GET'])]
    public function getMembersByGroupId(int $groupId): Response
    {
        return $this->json($this->memberService->findAllByTeamId($groupId));
    }
}
