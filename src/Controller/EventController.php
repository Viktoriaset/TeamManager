<?php

namespace App\Controller;

use App\Model\ErrorResponse;
use App\Model\MemberEventsResponse;
use App\Service\EventService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\GroupVisitedTableResponse;

class EventController extends AbstractController
{
    public function __construct(private EventService $eventService)
    {
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="return all events for group",
     *
     *     @Model(type=MemberEventsResponse::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="group not found",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '/api/v1/group/{groupId}/events', methods: ['GET'])]
    public function getGroupEvents(int $groupId): Response
    {
        return $this->json($this->eventService->getGroupEvents($groupId));
    }

    /**
     * @OA\Response(
     *     response=200,
     *     description="return visited table for group",
     *
     *     @Model(type=GroupVisitedTableResponse::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="group not found",
     *
     *     @Model(type=ErrorResponse::class)
     * )
     */
    #[Route(path: '//api/v1/group/{groupId}/visited_table', methods: ['GET'])]
    public function getGroupVisitedTable(int $groupId): Response
    {
        return $this->json($this->eventService->getGroupVisitedTable($groupId));
    }
}
