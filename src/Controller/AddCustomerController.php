<?php

namespace App\Controller;

use App\DTO\CustomerDTO;
use App\Entity\Customer;
use App\Service\AddCustomerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddCustomerController extends AbstractController
{

    /**
     * @Route("/api/customer-management/managed-customer", name="customer_add", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param AddCustomerManager $addCustomerManager
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function AddAction(Request $request, SerializerInterface $serializer, AddCustomerManager $addCustomerManager, EntityManagerInterface $em)
    {

        $reqContent = $request->getContent();

        /** @var CustomerDTO $customerDTO */
        $customerDTO = $serializer->deserialize($reqContent,CustomerDTO::class, 'json');

        $customer = new Customer(
            $customerDTO->name,
            $customerDTO->address,
            $customerDTO->email,
            $this->getUser()
        );

        $em->persist($customer);
        $em->flush();

        return new Response('L\'utilisateur a été ajouté avec succès !', Response::HTTP_CREATED);
    }
}