<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @UniqueEntity(
 *     fields={"name"})
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    private $link;

    /**
     * Customer constructor.
     *
     * @param $name
     * @param $address
     * @param $email
     * @param $user_id
     * @param $link
     */
    public function __construct($name, $address, $email, $user_id, $link)
    {
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->user_id = $user_id;
        $this->link = $link;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
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
