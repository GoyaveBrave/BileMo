<?php

namespace App\Service;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinkProducts
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
            'create' => $this->urlGeneratorInterface->generate('new_product', [], 0),
            'update' => $this->urlGeneratorInterface->generate('update_product', ['id' => 'id'], 0),
            'delete' => $this->urlGeneratorInterface->generate('remove_product', ['id' => 'id'], 0),
            'show list' => $this->urlGeneratorInterface->generate('show_products', [], 0),
            'show' => $this->urlGeneratorInterface->generate('show_product', ['id' => 'id'], 0),
        ];

        return $data;
    }
}