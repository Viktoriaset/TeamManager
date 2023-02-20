<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use App\Tests\MockUtils;

class UserControllerTest extends AbstractControllerTest
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testGetUsersByTeamId()
    {
        $user = MockUtils::createUser();
        $team = MockUtils::createTeam();
        $user->addTeam($team);

        $this->em->persist($user);
        $this->em->persist($team);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/team/'.$team->getId().'/members');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'firstName', 'secondName', 'patronymic'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'firstName' => ['type' => 'string'],
                            'secondName' => ['type' => 'string'],
                            'patronymic' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
