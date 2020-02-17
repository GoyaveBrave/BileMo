<?php

namespace App\Controller;

use App\Exceptions\NotFoundException;
use App\Repository\CustomerRepository;
use App\Service\CustomerSerializerManager;
use App\Service\LinksAdderCustomer;
use App\Service\ResponseManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Exceptions\AccessDeniedException;
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
     *
     * @throws NotFoundException
     */
    public function showOneAction(Request $request, SerializerInterface $serializer, CustomerRepository $customerRepository, $id, CustomerSerializerManager $customerSerializerManager, ResponseManager $response, LinksAdderCustomer $linksAdder, ValidatorInterface $validator)
    {
        $user = $this->getUser();
        $customer = $customerRepository->find($id);

        if (null === $customer) {
            throw new NotFoundException('This Customer does not exist ');
        } elseif ($this->getUser()->getId() !== $customer->getUserId()->getId()) {
            throw new AccessDeniedException('You don\'t have access to this');
        }

        $link = $linksAdder->addLink();
        $customer->setLink($link);

        $data = $customerSerializerManager->showSerializer($customer);

        return $response($data, $request, Response::HTTP_OK);
    }
}
