<?php

namespace App\Controller;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateProductController
{
    /**
     * @Route("/product-management/managed-products{id}", name="update_product", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Products $products
     * @return Response
     */
    public function updateAction(Request $request, $id, SerializerInterface $serializer, EntityManagerInterface $em, Products $products)
    {
        $req = $request->getContent();
        $data = $serializer->deserialize($req,Products::class, 'json');

        $products
            ->setName($data->getName())
            ->setContent($data->getContent())
            ->setPrice($data->getPrice());

        $em->flush();

        return new Response('Success', Response::HTTP_CREATED);
    }
}