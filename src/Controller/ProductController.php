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
     * @Route("/product/{id}", name="product_show")
     */
    public function showAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, $id)
    {
        $prod = new Products;
        $products = $em->getRepository(Products::class)
                       ->find($id);
        $jsonContent = $serializer->serialize($products, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);
        return $response;
    }

    /**
     * @Route("/products", name="products_show")
     */

     public function showAllAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
     {

        $prod = new Products;
        $products = $em->getRepository(Products::class)
                       ->findAll();
        $jsonContent = $serializer->serialize($products, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);
        return $response;
     }

    /**
     * @Route("/post-product", name="post_product", methods={"POST"})
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
