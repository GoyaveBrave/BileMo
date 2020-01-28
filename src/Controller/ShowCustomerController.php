<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ShowCustomerController extends AbstractController
{

    /**
     * @Route("/api/customer-management/managed-customer", name="customer_list_show", methods={"GET"})
     */
    public function showAction(Request $request, EntityManagerInterface $em, CustomerRepository $customerRepository, JsonEncoder $encoder)
    {
        $defaultContext = [ObjectNormalizer::IGNORED_ATTRIBUTES => ['userId']];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $user = $this->getUser();
        $customer = $customerRepository->findBy(array(
            "user_id" => $user
        ));

        $data = $serializer->serialize($customer, 'json');

        $response = new Response($data);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);

        return $response;
    }
}