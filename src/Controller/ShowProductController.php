<?php

namespace App\Controller;
use App\Entity\Products;
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
     * @throws \Exception
     */

    public function showAllAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ResponseManager $response)
    {
        $products = $em->getRepository(Products::class)
            ->findAll();
        if (!$products) {
            throw new \Exception("Add customers to see them !");
        }

        $data = $serializer->serialize($products, 'json');


        return $response->response($data, $request);
    }
}