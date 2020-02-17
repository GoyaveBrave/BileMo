<?php

namespace App\Controller;

use App\DTO\CustomerDTO;
use App\Repository\CustomerRepository;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateCustomerController extends AbstractController
{
    private $serializer;
    private $em;

    /**
     * UpdateCustomerController constructor.
     *
     * @param $serializer
     * @param $em
     */
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
    }

    /**
     * @Route("/api/customers/{id}", name="update_customer", methods={"PUT"})
     *
     * @param $id
     *
     * @return Response
     */
    public function updateAction(Request $request, $id, ResponseManager $responseManager, Response $response, CustomerRepository $customerRepository, LinksAdderCustomer $linksAdderCustomer, ValidatorInterface $validator)
    {
        $req = $request->getContent();
        $data = $this->serializer->deserialize($req, CustomerDTO::class, 'json');

        $customer = $customerRepository->find($id);
        if ($this->getUser()->getId() !== $customer->getUserId()->getId()) {
            throw new AccessDeniedException('You don\'t have access to this');
        }

        $customer
            ->setName($data->getName())
            ->setEmail($data->getEmail())
            ->setAddress($data->getAddress())
            ;

        $errors = $validator->validate($customer);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $this->em->flush();

        return $responseManager($data, $request, Response::HTTP_OK);
    }
}
