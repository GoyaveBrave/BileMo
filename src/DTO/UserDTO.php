<?php


namespace App\DTO;


class UserDTO
{
public $email;
public $token;

    /**
     * UserDTO constructor.
     * @param $email
     * @param $token
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

}