<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RemoveCustomerController extends AbstractController
{
    /**
     * @Route("/api/customers/{id}", name="remove_customer", methods={"DELETE"})
     *
     * @return Response
     */
    public function removeAction(EntityManagerInterface $em, CustomerRepository $repository, $id)
    {
        $customer = $repository->find($id);
        if ($this->getUser()->getId() !== $customer->getUserId()->getId()) {
            throw new AccessDeniedException('You don\'t have access to this');
        }
        $em->remove($customer);
        $em->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
