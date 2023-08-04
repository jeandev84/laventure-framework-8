<?php
namespace App\Entity;

class Product
{

     private ?int $id = null;
     private ?string $title = null;
     private ?string $description = null;
     private ?int $price = 0;
     private ?\DateTimeInterface $createdAt = null;
     private ?\DateTimeInterface $updatedAt = null;
     private ?\DateTimeInterface $deletedAt = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Product
     */
    public function setId(?int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Product
     */
    public function setTitle(?string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Product
     */
    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return Product
     */
    public function setPrice(?int $price): Product
    {
        $this->price = $price;
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
     * @return Product
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): Product
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
     * @return Product
    */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Product
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }



    /**
     * @return \DateTimeInterface|null
    */
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }




    /**
     * @param \DateTimeInterface|null $deletedAt
     *
     * @return $this
    */
    public function setDeletedAt(?\DateTimeInterface $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

}