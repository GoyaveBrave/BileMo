<?php

namespace App\Controller;

use App\DTO\CustomerDTO;
use App\Entity\Customer;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddCustomerController extends AbstractController
{
    private $json;

    /**
     * AddCustomerController constructor.
     * @param $json
     */
    public function __construct(JsonResponse $json)
    {
        $this->json = $json;
    }

    /**
     * @Route("/api/customers", name="customer_add", methods={"POST"})
     *
     * @return Response
     */
    public function AddAction(Request $request, LinksAdderCustomer $linksAdderCustomer, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, ResponseManager $reponse)
    {
        $reqContent = $request->getContent();

        /** @var CustomerDTO $customerDTO */
        $customerDTO = $serializer->deserialize($reqContent, CustomerDTO::class, 'json');

        $link = $linksAdderCustomer->addLink();

        $customer = new Customer(
            $customerDTO->name,
            $customerDTO->address,
            $customerDTO->email,
            $this->getUser(),
            $customerDTO->setLink($link)
        );

        $errors = $validator->validate($customer);

        if (count($errors) > 0) {

            return $this->json($errors, 400);
        }
        $em->persist($customer);
        $em->flush();

        return $reponse($customerDTO, $request, Response::HTTP_CREATED);
    }
}
