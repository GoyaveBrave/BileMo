<?php

namespace App\Service;
use Symfony\Component\HttpFoundation\Response;

class ResponseManager
{

    public function response($data, $request)
    {
        $response = new Response($data);
        $response->headers->set('Content-type',  'application/json');
        $response->setSharedMaxAge(3600);
        $response->setEtag(md5($response->getContent()));
        $response->setPublic(); // make sure the response is public/cacheable
        $response->isNotModified($request);

        return $response;
    }
}