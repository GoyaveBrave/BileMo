<?php

namespace App\Controller;

use App\Entity\Products;
use App\Exceptions\NotFoundException;
use App\Repository\ProductsRepository;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ShowProductController
{
    /**
     * @Route("/products", name="show_products", methods={"GET"})
     *
     * @return Response
     * @throws NotFoundException
     */
    public function showAllAction(Request $request, SerializerInterface $serializer, ProductsRepository $repository, ResponseManager $response, LinksAdderCustomer $linksAdder)
    {
        /** @var Products $products */
        $products = $repository->findAll();


        $link = $linksAdder->addLink();

        foreach ($products as $product) {
            $product->setLink($link);
        }

        return $response($products, $request, Response::HTTP_OK);
    }
}
