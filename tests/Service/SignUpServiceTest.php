<?php

namespace App\Tests\Service;

use App\Exception\UserAlredyExistsException;
use App\Model\SignUpRequest;
use App\Repository\UserRepository;
use App\Service\SignUpService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpServiceTest extends TestCase
{
    private UserRepository $userRepository;

    private UserPasswordHasherInterface $hasher;

    private EntityManagerInterface $em;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->hasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
    }

    public function testSignUpWhenUserAlreadyExists()
    {
        $this->expectException(UserAlredyExistsException::class);

        $this->userRepository->expects($this->once())
            ->method('existsByEmail')
            ->with('test@mail.com')
            ->willReturn(true);

        $signUpRequest = (new SignUpRequest())->setEmail('test@mail.com');

        (new signUpService($this->hasher, $this->userRepository, $this->em))->signUp($signUpRequest);
    }
}
