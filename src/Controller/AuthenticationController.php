<?php

namespace App\Controller;



use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

    /**
     * @Route("/api/test", name="test")
     *
     */
    public function test(Request $request)
    {
        dd($this->getUser());
    }
}
