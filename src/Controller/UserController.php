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
     * @Route("/api/user-management/managed-userr", name="users_show", methods={"GET"})
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

}
