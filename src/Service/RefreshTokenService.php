<?php
// src/Service/RefreshTokenService.php
namespace App\Service;

 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken;
use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGenerator;
use Symfony\Component\Security\Core\User\UserInterface; 

use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity]
#[ORM\Table(name: 'refresh_tokens')]
class RefreshTokenService
{
    private EntityManagerInterface $entityManager; 
    private BaseRefreshToken $baseRefreshTokenService;
    private RefreshTokenGenerator $refreshTokenGenerator;

    public function __construct(EntityManagerInterface $entityManager, RefreshTokenGenerator $refreshTokenGenerator)
    {
        $this->entityManager = $entityManager;
        $this->refreshTokenGenerator = $refreshTokenGenerator;
    }

    public function removeOldRefreshTokens(UserInterface $user)
    {
        $refreshTokenRepository = $this->entityManager->getRepository(RefreshToken::class);
        $refreshTokens = $refreshTokenRepository->findBy(['username' => $user->getUserIdentifier()]);

        foreach ($refreshTokens as $refreshToken) {
            $this->entityManager->remove($refreshToken);
        }

        $this->entityManager->flush();
    }   
    public function refresh(string $refreshToken)
    {
        return $this->baseRefreshTokenService->getRefreshToken($refreshToken);
    }

    public function generate(UserInterface $user): RefreshToken
    {
        $refreshToken = $this->refreshTokenGenerator->createForUserWithTtl($user,2592000);
        $this->entityManager->persist($refreshToken);
        $this->entityManager->flush();

        return $refreshToken;
    }
}
