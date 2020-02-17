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

class ShowProductDetailsController
{
    /**
     * @Route("/products/{id}", name="show_product", methods={"GET"})
     *
     * @param $id
     *
     * @return Response
     *
     * @throws NotFoundException
     */
    public function showAction(Request $request, SerializerInterface $serializer, ProductsRepository $repository, $id, ResponseManager $response, LinksAdderCustomer $linksAdder)
    {
        /** @var Products $products */
        $products = $repository->find($id);

        if (null === $products) {
            throw new NotFoundException('This product does not exist ');
        }

        $link = $linksAdder->addLink();
        $products->setLink($link);

        return $response($products, $request, Response::HTTP_OK);
    }
}
