<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseManager
{
    private $jsonEncoder;
    private $serializer;

    /**
     * ResponseManager constructor.
     *
     * @param $jsonEncoder
     */
    public function __construct(JsonEncoder $jsonEncoder, SerializerInterface $serializer)
    {
        $this->jsonEncoder = $jsonEncoder;
        $this->serializer = $serializer;
    }

    public function __invoke($data, $request, $statusCode)
    {
        if (!is_string($data)) {
            $json = $this->serializer->serialize($data, 'json', array_merge(['json_encode_options' => JSON_UNESCAPED_SLASHES], []));
            $response = new Response($json);
        } else {
            $response = new Response($data);
        }

        $response->headers->set('Content-type', 'application/json');
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);
        $response->setStatusCode($statusCode);

        return $response;
    }
}
