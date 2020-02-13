<?php

namespace App\Controller;

use App\DTO\ProductsDTO;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateProductController
{
    /**
     * @Route("/products/{id}", name="update_product", methods={"PUT"})
     *
     * @param Request $request
     * @param $id
     *
     * @param LinksAdderCustomer $linksAdderCustomer
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ProductsRepository $repository
     * @param ResponseManager $response
     * @return Response
     */
    public function updateAction(Request $request, $id, LinksAdderCustomer $linksAdderCustomer, SerializerInterface $serializer, EntityManagerInterface $em, ProductsRepository $repository, ResponseManager $response)
    {
        $req = $request->getContent();
        $data = $serializer->deserialize($req, ProductsDTO::class, 'json');


        $products = $repository->find($id);
        $link = $linksAdderCustomer->addLink();

        $products
            ->setName($data->getName())
            ->setContent($data->getContent())
            ->setPrice($data->getPrice())
            ->setLink($link);

        $em->flush();

        return $response($data, $request, Response::HTTP_OK);
    }
}
