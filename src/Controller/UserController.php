<?php

namespace App\Controller;


use App\DTO\CreateUserDTO;
use App\DTO\CustomerDTO;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user-management/managed-user", name="users_show", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function showAllAction(Request $request, EntityManagerInterface $em)
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
    AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
        return $object->getName();
    },
];
$normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);



$serializer = new Serializer([$normalizer], [$encoder]);
        //$user = new User;
        $users = $em->getRepository(User::class)
                    ->findAll();

        $data = $serializer->serialize($users, 'json');
        $response = new Response($data);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);
        return $response;
    }
    /**
     * @Route("/user-management/managed-user{id}", name="user_show", methods={"GET"})
     */
    public function showAction(Request $request, EntityManagerInterface $em, $id, User $user)
    {
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];

        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);
        $data = $serializer->serialize($user, 'json');

        $response = new Response($data);
        $response->headers->set('Content-type',  'application/json');
        //$response->setSharedMaxAge(15);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/user-management/managed-user", name="user_add", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     * @param CreateUserDTO $createUserDTO
     * @return Response
     */
    public function addUserAction(Request $request, EntityManagerInterface $em, SerializerInterface $serializer, CreateUserDTO $createUserDTO)
    {
        $encoders = [ new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $reqContent = $request->getContent();

        /** @var CustomerDTO $customerDTO */
        $customerDTO = $serializer->deserialize($reqContent,CustomerDTO::class, 'json');
        $customer = new Customer(
            $customerDTO->name,
            $customerDTO->address,
            $customerDTO->email,
            $this->getUser()
        );
        dd($this->getUser());

        //TU DOIS REUSSIR A METTRE LE USER_ID AUTOMATIQUEMENT, NORMALEMENT C'EST EN ETANT CONNECTE MAIS PAS SUR
        $em->persist($customer);
        $em->flush();

        return new Response('Success', Response::HTTP_CREATED);
    }
}
