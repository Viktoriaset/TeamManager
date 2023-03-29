<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;
use App\Tests\MockUtils;

class EventControllerTest extends AbstractControllerTest
{
    public function testGetGroupEvents()
    {
        $user = MockUtils::createUser();
        $group = MockUtils::createGroup();
        $member = MockUtils::createMember($user, $group);
        $event = MockUtils::createEvent($member);

        $this->em->persist($user);
        $this->em->persist($group);
        $this->em->persist($member);
        $this->em->persist($event);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/group/'.$group->getId().'/events');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['member', 'items'],
            'properties' => [
                'member' => [
                    'type' => 'object',
                    'required' => ['userId', 'firstName', 'secondName', 'patronymic'],
                    'properties' => [
                        'userId' => ['type' => 'integer'],
                        'firstName' => ['type' => 'string'],
                        'secondName' => ['type' => 'string'],
                        'patronymic' => ['type' => 'string'],
                    ],
                ],
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'datetime', 'visited', 'description'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'datetime' => ['type' => 'integer'],
                            'visited' => ['type' => 'boolean'],
                            'description' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]);

        $this->em->remove($event);
        $this->em->flush();
    }

    public function testGetGroupVisitedTable()
    {
        $user = MockUtils::createUser();
        $group = MockUtils::createGroup();
        $member = MockUtils::createMember($user, $group);
        $event = MockUtils::createEvent($member);

        $this->em->persist($user);
        $this->em->persist($group);
        $this->em->persist($member);
        $this->em->persist($event);
        $this->em->flush();

        $this->client->request('GET', '/api/v1/group/'.$group->getId().'/visited_table');
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
                        'required' => ['member', 'items'],
                        'properties' => [
                            'member' => [
                                'type' => 'object',
                                'required' => ['userId', 'firstName', 'secondName', 'patronymic'],
                                'properties' => [
                                    'userId' => ['type' => 'integer'],
                                    'firstName' => ['type' => 'string'],
                                    'secondName' => ['type' => 'string'],
                                    'patronymic' => ['type' => 'string'],
                                ],
                            ],
                            'items' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'required' => ['id', 'datetime', 'visited', 'description'],
                                    'properties' => [
                                        'id' => ['type' => 'integer'],
                                        'datetime' => ['type' => 'integer'],
                                        'visited' => ['type' => 'boolean'],
                                        'description' => ['type' => 'string'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            ]);

        $this->em->remove($event);
        $this->em->flush();
    }
}
