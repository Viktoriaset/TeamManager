<?php

namespace App\Tests\Controller;

use App\Controller\GroupController;
use App\Tests\AbstractControllerTest;
use App\Tests\MockUtils;
use PHPUnit\Framework\TestCase;

class TeamControllerTest extends AbstractControllerTest
{

    public function testGetTeamsByUserId()
    {
        $user = MockUtils::createUser();
        $team = MockUtils::createTeam();
        $user->addTeam($team);

        $this->em->persist($user);
        $this->em->persist($team);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/user/'.$user->getId().'/teams');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['teams'],
            'properties' => [
                'teams' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'title', 'description'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'title' => ['type' => 'string'],
                            'description' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
