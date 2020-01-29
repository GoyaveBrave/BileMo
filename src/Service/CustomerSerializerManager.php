<?php

namespace App\Service;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ShowSerializerManager
{


    public function showSerializer($customer)
    {
        $encoder = new JsonEncoder();
        $defaultContext = [ObjectNormalizer::IGNORED_ATTRIBUTES => ['userId']];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);

        return $serializer->serialize($customer, 'json');
    }
}