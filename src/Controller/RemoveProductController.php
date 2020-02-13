<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RemoveProductController extends AbstractController
{
    /**
     * @Route("/products/{id}", name="remove_product", methods={"DELETE"})
     * @param EntityManagerInterface $em
     * @param Products $products
     * @return Response
     */
    public function removeAction(EntityManagerInterface $em, Products $products)
    {
        $em->remove($products);
        $em->flush();

        return new Response(Response::HTTP_NO_CONTENT);
    }
}