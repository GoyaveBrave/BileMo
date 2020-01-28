<?php

namespace App\Controller;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ShowCustomerDetailsController extends AbstractController
{
    /**
     * @Route("/api/customer-management/managed-customers{id}", name="customer_show", methods={"GET"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param CustomerRepository $customerRepository
     * @param $id
     * @param JsonEncoder $encoder
     * @return Response
     */
    public function showOneAction(Request $request, SerializerInterface $serializer, CustomerRepository $customerRepository, $id, JsonEncoder $encoder)
    {
        $defaultContext = [ObjectNormalizer::IGNORED_ATTRIBUTES => ['userId']];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $user = $this->getUser();


        $customer = $customerRepository->findBy(
            array('id' => $id,
                'user_id' => $user ));

        $jsonContent = $serializer->serialize($customer, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);
        return $response;
    }
}