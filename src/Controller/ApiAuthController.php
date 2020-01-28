<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiAuthController extends AbstractController
{
    /**
     * @Route("/api/auth", name="api_auth")
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $encoders = [ new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $product = $request->getContent();
        $data = $serializer->deserialize($product, Products::class, 'json');

        $manager->persist($data);
        $manager->flush();
        return new Response('Success', Response::HTTP_CREATED);
    }

}
