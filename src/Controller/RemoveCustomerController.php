<?php

namespace App\Controller;
use App\Entity\Customer;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveCustomerController
{
    /**
     * @Route("/api/customer-management/managed-customer{id}", name="remove_customer", methods={"DELETE"})
     * @param EntityManagerInterface $em
     * @param Customer $customer
     * @return Response
     */
    public function removeAction(EntityManagerInterface $em, Customer $customer)
    {
        $em->remove($customer);
        $em->flush();

        return new Response('Success', Response::HTTP_CREATED);
    }
}