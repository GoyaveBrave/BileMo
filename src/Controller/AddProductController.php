<?php

namespace App\Controller;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddProductController
{
    /**
     * @Route("/product-management/managed-products", name="new_product", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $product = $request->getContent();
        $data = $serializer->deserialize($product, Products::class, 'json');

        $manager->persist($data);
        $manager->flush();

        return new Response('Success', Response::HTTP_CREATED);
    }
}