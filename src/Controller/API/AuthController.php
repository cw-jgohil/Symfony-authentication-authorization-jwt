<?php 
// src/Controller/AuthController.php
namespace App\Controller\API;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Entity\RefreshToken;
use App\Entity\User; 
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AuthController extends AbstractController

{

     
    #[Route('/api/login_check', name: 'api_login_check', methods: ['POST'])]
    public function login(): JsonResponse
    {
        // The JWT bundle handles the authentication process automatically
        return new JsonResponse(['message' => 'Logged in successfully']);
    } 

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        echo '';
        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles($data['roles']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));

        // Validate the user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(['errors' => $errorsString], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Persist the user entity
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User registered successfully'], JsonResponse::HTTP_CREATED);
    }
    #[Route('/api/user/update/{id}', name: 'api_user_update', methods: ['PATCH'])]
    public function updateUser(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $entityManager->getRepository(User::class)->find($id);
        // Get the currently authenticated user
        // $user = new User();

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        if (!$user) {
            throw new AccessDeniedException('You must be logged in to update your profile.');
        }

        // Update user fields
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['roles'])) {
            $user->setRoles($data['roles']);
        }
        if (isset($data['password'])) {
            $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        }

        // Validate the user entity
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(['errors' => $errorsString], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            // Persist the user entity
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (ORMException $e) {
            return new JsonResponse(['error' => 'An error occurred while updating the profile.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['message' => 'User updated successfully'], JsonResponse::HTTP_OK);
    }
    #[Route('/api/user/delete/{id}', name: 'api_user_delete', methods: ['DELETE'])]
    public function deleteUser(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher, int $id): JsonResponse
    {
        // $data = json_decode($request->getContent(), true);
        $user = $entityManager->getRepository(User::class)->find($id);
        // Get the currently authenticated user
        // $user = new User();

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        if (!$user) {
            throw new AccessDeniedException('You must be logged in to delete your profile.');
        }

       

        try {
            $entityManager->remove($user); 
            $entityManager->flush();
        } catch (ORMException $e) {
            return new JsonResponse(['error' => 'An error occurred while deleting the profile.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['message' => 'User deleted successfully'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/token/refresh', name: 'api_refresh_token', methods: ['POST'])]
    public function refresh(Request $request,RefreshToken $refreshTokenService): JsonResponse
    {
        $refreshToken = $request->get('refresh_token');

        try {
            // Use the 'refresh_jwt' authenticator logic here
            $newToken =  $refreshTokenService->getRefreshToken();
            return new JsonResponse(['token' => $newToken], 200);
        } catch (AuthenticationException $e) {
            return new JsonResponse(['error' => 'Invalid refresh token'], 401);
        }
    }
}  