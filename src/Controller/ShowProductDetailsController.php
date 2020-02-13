<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ShowProductDetailsController
{

    /**
     * @Route("/products/{id}", name="show_product", methods={"GET"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ProductsRepository $repository
     * @param $id
     *
     * @param ResponseManager $response
     * @param LinksAdderCustomer $linksAdder
     * @return Response
     */
    public function showAction(Request $request, SerializerInterface $serializer, ProductsRepository $repository, $id, ResponseManager $response, LinksAdderCustomer $linksAdder)
    {
        /** @var Products $products */
        $products = $repository->find($id);

        $link = $linksAdder->addLink();
        $products->setLink($link);

        return $response($products, $request, Response::HTTP_OK);
    }
}
