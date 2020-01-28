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
     * @Route("/product-management/managed-products{id}", name="show_product", methods={"GET"})
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
     * @Route("/product-management/managed-products", name="show_products", methods={"GET"})
     */

     public function showAllAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
     {

        $prod = $em->getRepository(Products::class)
                       ->findAll();
        $data = $serializer->serialize($prod, 'json');

        $response = new Response($data);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);
        return $response;
     }

    /**
     * @Route("/product-management/managed-products", name="new_product", methods={"POST"})
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

    /**
     * @Route("/product-management/managed-products{id}", name="update_product", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function updateAction(Request $request, $id, SerializerInterface $serializer, EntityManagerInterface $em, Products $products)
    {
        $encoders = [ new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $req = $request->getContent();
        $data = $serializer->deserialize($req,Products::class, 'json');
        $products->setName($data->getName())
                 ->setContent($data->getContent())
                 ->setPrice($data->getPrice());
        $em->flush();
        return new Response('Success', Response::HTTP_CREATED);
    }
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
