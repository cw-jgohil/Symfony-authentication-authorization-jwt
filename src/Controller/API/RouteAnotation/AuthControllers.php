<?php
// src/Controller/API/AuthController.php
namespace App\Controller\API\RouteAnotation;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthControllers extends AbstractController
{
    // public function logins(): JsonResponse
    // {
    //     // The JWT bundle handles the authentication process automatically
    //     return new JsonResponse(['message' => 'Logged in successfully']);
    // }

    // public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);

    //     $user = new User();
    //     $user->setEmail($data['email']);
    //     $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

    //     // Validate the user entity
    //     $errors = $validator->validate($user);
    //     if (count($errors) > 0) {
    //         $errorsString = (string) $errors;
    //         return new JsonResponse(['errors' => $errorsString], JsonResponse::HTTP_BAD_REQUEST);
    //     }

    //     // Persist the user entity
    //     $entityManager->persist($user);
    //     $entityManager->flush();

    //     return new JsonResponse(['message' => 'User registered successfully'], JsonResponse::HTTP_CREATED);
    // }

    // public function refresh(Request $request, RefreshToken $refreshTokenService): JsonResponse
    // {
    //     $refreshToken = $request->get('refresh_token');

    //     try {
    //         $newToken = $refreshTokenService->refresh($refreshToken);
    //         return new JsonResponse(['token' => $newToken], 200);
    //     } catch (AuthenticationException $e) {
    //         return new JsonResponse(['error' => 'Invalid refresh token'], 401);
    //     }
    // }
}
