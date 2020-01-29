<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Service\ResponseManager;
use App\Service\CustomerSerializerManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ShowCustomerController extends AbstractController
{

    /**
     * @Route("/api/customer-management/managed-customer", name="customer_list_show", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CustomerRepository $customerRepository
     * @param CustomerSerializerManager $customerSerializerManager
     * @param ResponseManager $response
     * @return Response
     */
    public function showAction(Request $request, EntityManagerInterface $em, CustomerRepository $customerRepository, CustomerSerializerManager $customerSerializerManager, ResponseManager $response)
    {
        $user = $this->getUser();

        $customer = $customerRepository->findBy(array(
            "user_id" => $user
        ));

        $data = $customerSerializerManager->showSerializer($customer);

        return $response->response($data, $request);
    }
}