<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function index(UserAuthenticatorInterface $authenticator): JsonResponse
    {
//         if (null === $user) {
//                     return $this->json([
//                          'message' => 'missing credentials',
//                       ], Response::HTTP_UNAUTHORIZED);
//                   }
         
//         $token = '...'; // somehow create an API token for $user
//         return $this->json([
//             'user'  => $user->getUserIdentifier(),
// +           'token' => $token,
//         ]);
 // The JWT bundle handles the authentication process automatically
 return new JsonResponse(['message' => 'Logged in successfully','res'=>$authenticator],200);
    }
}

// src/Controller/AuthController.php
// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
// use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
// use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;

// class AuthController extends AbstractController
// {
//     #[Route('/api/login_check', name: 'api_login_check', methods: ['POST'])]
//     public function login(UserAuthenticatorInterface $authenticator): JsonResponse
//     {
//         // The JWT bundle handles the authentication process automatically
//         return new JsonResponse(['message' => 'Logged in successfully']);
//     }
// }
