<?php

namespace App\Controller;

use App\DTO\ProductsDTO;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateProductController extends AbstractController
{
    /**
     * @Route("/products/{id}", name="update_product", methods={"PUT"})
     *
     * @param $id
     *
     * @return Response
     */
    public function updateAction(Request $request, $id, LinksAdderCustomer $linksAdderCustomer, SerializerInterface $serializer, EntityManagerInterface $em, ProductsRepository $repository, ResponseManager $response, ValidatorInterface $validator)
    {
        $req = $request->getContent();
        $data = $serializer->deserialize($req, ProductsDTO::class, 'json');

        $products = $repository->find($id);
        $link = $linksAdderCustomer->addLink();

        $products
            ->setName($data->getName())
            ->setContent($data->getContent())
            ->setPrice($data->getPrice())
            ;
        $errors = $validator->validate($products);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->flush();

        return $response($data, $request, Response::HTTP_OK);
    }
}
