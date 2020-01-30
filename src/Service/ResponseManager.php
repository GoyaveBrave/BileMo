<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Response;

class ResponseManager
{

    public function response($data, $request)
    {
        $response = new Response($data);
        $response->headers->set('Content-type',  'application/json');
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }
}