<?php

namespace App\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinksAdderCustomer
{
    private $urlGeneratorInterface;
    public $data;

    /**
     * LinksAdderCustomer constructor.
     *
     * @param $urlGeneratorInterface
     */
    public function __construct(UrlGeneratorInterface $urlGeneratorInterface)
    {
        $this->urlGeneratorInterface = $urlGeneratorInterface;
    }

    public function addLink()
    {
        $data = [
            'create' => $this->urlGeneratorInterface->generate('customer_add', [], 0),
            'update' => $this->urlGeneratorInterface->generate('update_customer', ['id' => 'id'], 0),
            'delete' => $this->urlGeneratorInterface->generate('remove_customer', ['id' => 'id'], 0),
            'show list' => $this->urlGeneratorInterface->generate('customer_list_show', [], 0),
            'show' => $this->urlGeneratorInterface->generate('customer_show', ['id' => 'id'], 0),
        ];

        return $data;
    }

}
