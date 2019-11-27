<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_show")
     */
    public function showAction(SerializerInterface $serializer)
    {
        $product = new Products;
        $product
                ->setName('Mon premier joli article qui tue')
                ->setContent('Ceci est mon contenu fwewo');
        $jsonContent = $serializer->serialize($product, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-type', 'application/json');
        
        return $response;
    }

    /**
     * @Route("/products", name="post_product")
     */
    public function createAction(Request $request)
    {

        $encoders = [ new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        
        $jsonContent = $request->getContent();
        dd($serializer->deserialize($jsonContent, Product::class, 'json'));

        dump($product); die;
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        echo $product;
    }
}
