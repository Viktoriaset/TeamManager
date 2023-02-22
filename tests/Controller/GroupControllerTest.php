<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use App\Tests\MockUtils;

class GroupControllerTest extends AbstractControllerTest
{
    public function testGetTeamsByUserId()
    {
        $user = MockUtils::createUser();
        $group = MockUtils::createGroup();

        $this->em->persist($user);
        $this->em->persist($group);
        $this->em->persist(MockUtils::createMember($user, $group));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/user/'.$user->getId().'/teams');
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
