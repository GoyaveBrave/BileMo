<?php


namespace App\DTO;


use App\Entity\User;

class CreateUserDTO
{

    private $user;

    public function build(UserDTO $userDTO)
    {
        $this->user = new User(
            $userDTO->$this->email,
            $userDTO->$this->token
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