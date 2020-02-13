<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\CustomerSerializerManager;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ShowCustomerController extends AbstractController
{
    /**
     * @Route("/api/customers", name="customer_list_show", methods={"GET"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CustomerRepository $customerRepository
     * @param CustomerSerializerManager $customerSerializerManager
     * @param ResponseManager $response
     * @param ValidatorInterface $validator
     * @param LinksAdderCustomer $linksAdder
     * @return Response
     */
    public function showAction(Request $request, EntityManagerInterface $em, CustomerRepository $customerRepository, CustomerSerializerManager $customerSerializerManager, ResponseManager $response, ValidatorInterface $validator, LinksAdderCustomer $linksAdder)
    {
        $user = $this->getUser();

        /** @var Customer $customer */
        $customer = $customerRepository->getAllCustomers($user);

        $errors = $validator->validate($customer);

        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $link = $linksAdder->addLink();
        foreach ($customer as $customers) {
            $customers->setLink($link);
        }
        $data = $customerSerializerManager->showSerializer($customer);

        return $response($data, $request, Response::HTTP_OK);
    }
}
