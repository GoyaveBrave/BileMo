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


class ProductController extends AbstractController
{







    /**
     * @Route("/product-management/managed-products{id}", name="remove_product", methods={"DELETE"})
     */
    public function removeAction(Request $request, $id, EntityManagerInterface $em, Products $products)
    {
        $em->remove($products);
        $em->flush();
        return new Response('Success', Response::HTTP_CREATED);
    }
}
