<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveCustomerController
{
    /**
     * @Route("/api/customers/{id}", name="remove_customer", methods={"DELETE"})
     *
     * @return Response
     */
    public function removeAction(EntityManagerInterface $em, Customer $customer)
    {
        $em->remove($customer);
        $em->flush();

        return new Response(Response::HTTP_NO_CONTENT);
    }
}
