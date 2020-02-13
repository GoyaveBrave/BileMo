<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\CustomerSerializerManager;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ShowCustomerDetailsController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * ShowCustomerController constructor.
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/api/customers/{id}", name="customer_show", methods={"GET"})
     *
     * @param $id
     *
     * @return Response
     */
    public function showOneAction(Request $request, SerializerInterface $serializer, CustomerRepository $customerRepository, $id, CustomerSerializerManager $customerSerializerManager, ResponseManager $response, LinksAdderCustomer $linksAdder, ValidatorInterface $validator)
    {
        $user = $this->getUser();
        $customer = $customerRepository->getOneCustomer($id, $user);

        $link = $linksAdder->addLink();
        foreach ($customer as $customers) {
            $customers->setLink($link);
        }

        $data = $customerSerializerManager->showSerializer($customer);

        return $response($data, $request, Response::HTTP_OK);
    }
}
