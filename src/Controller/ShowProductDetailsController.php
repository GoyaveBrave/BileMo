<?php

namespace App\Controller;
use App\Entity\Products;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ShowProductDetailsController
{
    /**
     * @Route("/product-management/managed-products{id}", name="show_product", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param $id
     * @param ResponseManager $response
     * @return Response
     * @throws \Exception
     */
    public function showAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, $id, ResponseManager $response)
    {
        $products = $em->getRepository(Products::class)->find($id);
        if (!$products) {
            throw new \Exception("This customer does not exist ! Please try an other id or add him");
        }
        $data = $serializer->serialize($products, 'json');

        return $response->response($data, $request);
    }
}