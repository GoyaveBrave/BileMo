<?php

namespace App\DTO;


use App\Entity\Customer;

class CreateCustomerDTO
{
    private $user;

    public function build(CustomerDTO $customerDTO)
    {
        $this->user = new Customer(
            $customerDTO->$this->email,
            $customerDTO->$this->name,
            $customerDTO->$this->address
        );
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }


}