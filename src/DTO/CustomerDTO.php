<?php

namespace App\DTO;
class CustomerDTO
{
    public $name;
    public $address;
    public $email;
    public $user_id;

    /**
     * CreateCustomerDTO constructor.
     * @param $name
     * @param $address
     * @param $email
     * @param $user_id
     */
    public function __construct($name, $address, $email, $user_id)
    {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->user_id = $user_id;
    }
}