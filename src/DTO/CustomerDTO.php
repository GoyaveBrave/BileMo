<?php

namespace App\DTO;

class CustomerDTO
{
    public $name;
    public $address;
    public $email;
    //public $user_id;
    public $link;

    /**
     * CreateCustomerDTO constructor.
     *
     * @param $address
     * @param $email
     * @param $user_id
     */
    public function __construct(string $name, $address, $email)
    {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */


    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $user_id
     */


    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     *
     * @return mixed
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $link;
    }
}
