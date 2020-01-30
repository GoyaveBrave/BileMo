<?php

namespace App\Controller;
use App\Entity\Customer;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateCustomerController extends AbstractController
{

    /**
     * @Route("/api/customer-management/managed-customer{id}", name="update_customer", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Customer $customer
     * @return Response
     */
    public function updateAction(Request $request, $id, SerializerInterface $serializer, EntityManagerInterface $em, Customer $customer)
    {
        $req = $request->getContent();
        $data = $serializer->deserialize($req,Customer::class, 'json');

        $customer
            ->setName($data->getName())
            ->setAddress($data->getAddress())
            ->setEmail($data->getEmail())
            ->setUserId($this->getUser());

        $em->flush();

        return new Response('You have successfully updated', Response::HTTP_CREATED);
    }
}