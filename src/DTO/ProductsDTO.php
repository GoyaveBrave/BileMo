<?php

namespace App\DTO;

class ProductsDTO
{
    public $name;
    public $price;
    public $content;
    public $picture;
    public $link;

    /**
     * ProductsDTO constructor.
     *
     * @param $name
     * @param $price
     * @param $content
     * @param $picture
     * @param $link
     */
    public function __construct($name, $price, $content, $picture)
    {
        $this->name = $name;
        $this->price = $price;
        $this->content = $content;
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }

    /**
     * @param mixed $link
     * @return mixed
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $link;
    }
}
