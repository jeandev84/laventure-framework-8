<?php
namespace App\Entity;

use Collection;
use DateTimeImmutable;

class User
{

    private ?int $id = null;
    private ?string $email;
    private ?string $password;
    private ?string $username;
    private ?bool $active;
    private Collection $products;
    private ?\DateTimeInterface $createdAt;
    private ?\DateTimeInterface $updatedAt = null;



    public function __construct()
    {
        $this->products = new Collection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }





    /**
     * @return string|null
    */
    public function getEmail(): ?string
    {
        return $this->email;
    }




    /**
     * @param string|null $email
     *
     * @return $this
    */
    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }





    /**
     * @param string|null $username
     *
     * @return $this
     */
    public function setUsername(?string $username): static
    {
        $this->username = $username;

        return $this;
    }





    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }





    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }





    /**
     * @param string|null $password
     *
     * @return $this
     */
    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }




    /**
     * @return bool|null
    */
    public function getActive(): ?bool
    {
        return $this->active;
    }




    /**
     * @param bool|null $active
     * @return User
    */
    public function setActive(?bool $active): User
    {
        $this->active = $active;

        return $this;
    }





    /**
     * @return \DateTimeInterface|null
    */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }




    /**
     * @param \DateTimeInterface|null $createdAt
     *
     * @return $this
    */
    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }




    /**
     * @return \DateTimeInterface|null
    */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }







    /**
     * @param \DateTimeInterface|null $updatedAt
     *
     * @return $this
    */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }




}