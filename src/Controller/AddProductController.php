<?php

namespace App\Controller;

use App\DTO\ProductsDTO;
use App\Entity\Products;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddProductController extends AbstractController
{
    /**
     * @Route("/products", name="new_product", methods={"POST"})
     *
     * @return Response
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, LinksAdderCustomer $linksAdderCustomer, ResponseManager $response, ValidatorInterface $validator)
    {
        $req = $request->getContent();

        /** @var ProductsDTO $productsDTO */
        $productsDTO = $serializer->deserialize($req, ProductsDTO::class, 'json');

        $link = $linksAdderCustomer->addLink();

        $products = new Products(
            $productsDTO->name,
            $productsDTO->content,
            $productsDTO->price,
            $productsDTO->picture,
            $productsDTO->setLink($link)
        );
        $errors = $validator->validate($products);

        if (count($errors) > 0) {

            return $this->json($errors, 400);
        }

        $manager->persist($products);
        $manager->flush();

        return $response($products, $request, Response::HTTP_CREATED);
    }
}
