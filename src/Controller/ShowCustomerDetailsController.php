<?php

namespace App\Controller;
use App\Repository\CustomerRepository;
use App\Service\ResponseManager;
use App\Service\CustomerSerializerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ShowCustomerDetailsController extends AbstractController
{
    /**
     * @Route("/api/customer-management/managed-customer{id}", name="customer_show", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param CustomerRepository $customerRepository
     * @param $id
     * @param CustomerSerializerManager $customerSerializerManager
     * @param ResponseManager $response
     * @return Response
     */
    public function showOneAction(Request $request, SerializerInterface $serializer, CustomerRepository $customerRepository, $id, CustomerSerializerManager $customerSerializerManager, ResponseManager $response)
    {
        $user = $this->getUser();

        $customer = $customerRepository->findBy(
            array('id' => $id,
                'user_id' => $user ));

        $data = $customerSerializerManager->showSerializer($customer);


        return $response->response($data, $request);
    }
}