<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use App\Tests\MockUtils;

class MemberControllerTest extends AbstractControllerTest
{
    public function testGetMembersByGroupId()
    {
        $user = MockUtils::createUser();
        $group = MockUtils::createGroup();

        $this->em->persist($user);
        $this->em->persist($group);
        $this->em->persist(MockUtils::createMember($user, $group));
        $this->em->flush();

        $this->client->request('GET', '/api/v1/group/'.$group->getId().'/members');
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
                        'required' => ['userId', 'firstName', 'secondName', 'patronymic'],
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
