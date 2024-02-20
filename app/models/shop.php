<?php

class Shop
{
    private int $id;
    private int $user_id;
    private string $name;
    private string $description;
    private string $address;
    private string $contact_email;
    private string $contact_number;
    private string $created_at;
    private string $updated_at;

    // Getters and setters

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getOwnerId(): int
    {
        return $this->user_id;
    }

    public function setOwnerId(int $user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getContactEmail(): string
    {
        return $this->contact_email;
    }

    public function setContactEmail(string $contact_email): self
    {
        $this->contact_email = $contact_email;
        return $this;
    }

    public function getContactNumber(): string
    {
        return $this->contact_number;
    }

    public function setContactNumber(string $contact_number): self
    {
        $this->contact_number = $contact_number;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}
