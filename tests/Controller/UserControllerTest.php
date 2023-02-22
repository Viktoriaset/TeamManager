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
        $group = MockUtils::createGroup();

        $this->em->persist($user);
        $this->em->persist($group);
        $this->em->persist(MockUtils::createMember($user, $group));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/user/'.$user->getId());
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['id', 'firstName', 'secondName', 'patronymic'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'firstName' => ['type' => 'string'],
                'secondName' => ['type' => 'string'],
                'patronymic' => ['type' => 'string'],
            ],
        ]);
    }
}
