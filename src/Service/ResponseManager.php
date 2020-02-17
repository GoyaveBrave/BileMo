<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseManager
{
    private $jsonEncoder;
    private $serializer;
    private $req;

    /**
     * ResponseManager constructor.
     *
     * @param $jsonEncoder
     */
    public function __construct(JsonEncoder $jsonEncoder, SerializerInterface $serializer, Request $req)
    {
        $this->jsonEncoder = $jsonEncoder;
        $this->serializer = $serializer;
        $this->req = $req;
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
        if ($this->req->isMethodCacheable()) {
            $response->setEtag(md5($response->getContent()));
            $response->setPublic();
            $response->isNotModified($request);
        }

        $response->setStatusCode($statusCode);

        return $response;
    }
}
