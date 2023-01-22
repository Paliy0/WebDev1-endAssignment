<?php
class Product
{

    private int $id;
    private string $name;
    private string $description;
    private int $storeId;
    private string $storeName;
    private float $price;
    private int $quantity;
    private string $img;


    // Getters and setters generated using https://docs.devsense.com/en/vscode/editor/code-actions

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id 
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name 
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->description;
    }

    /**
     * @param string $description 
     * @return self
     */
    public function setDesc(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }


    /**
     * @param int $storeId 
     * @return self
     */
    public function setStoreId(int $storeId): self
    {
        $this->storeId = $storeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreName(): string
    {
        return $this->storeName;
    }


    /**
     * @param string $storeName 
     * @return self
     */
    public function setStoreName(string $storeName): self
    {
        $this->storeName = $storeName;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price 
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity 
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img 
     * @return self
     */
    public function setImg(string $img): self
    {
        $this->img = $img;
        return $this;
    }
}
