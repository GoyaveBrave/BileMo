<?php

namespace App\Controller;
use App\Entity\Products;
use App\Service\CustomerSerializerManager;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ShowProductController
{
    /**
     * @Route("/product-management/managed-products", name="show_products", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ResponseManager $response
     * @return Response
     */

    public function showAllAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ResponseManager $response)
    {
        $prod = $em->getRepository(Products::class)
            ->findAll();

        $data = $serializer->serialize($prod, 'json');

        return $response->response($data, $request);
    }
}