<?php

namespace App\Controller;



use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController extends AbstractController
{
    public function api(Request $request)
    {
        $user = $this->getUser();

        $key = "token";
        $payload = array(
            'id' => $user->getId(),
            'email' => $user->getEmail()
        );

        $jwt = JWT::encode($payload, $key);

        return $this->json([
            'email' => $user->getEmail(),
            'Token' => $jwt,
        ]);
    }
}
