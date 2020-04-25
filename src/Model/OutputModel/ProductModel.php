<?php


namespace App\Model\OutputModel;


class ProductModel
{
    /** @var int|null */
    private $id;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $image;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $seo_title;

    /** @var string|null */
    private $seo_description;

    /** @var string|null */
    private $sub_category;

    private $price;

    private $isVisible;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ProductModel
     */
    public function setId(?int $id): ProductModel
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
     * @return ProductModel
     */
    public function setTitle(?string $title): ProductModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return ProductModel
     */
    public function setImage(?string $image): ProductModel
    {
        $this->image = $image;
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
     * @return ProductModel
     */
    public function setDescription(?string $description): ProductModel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeoTitle(): ?string
    {
        return $this->seo_title;
    }

    /**
     * @param string|null $seo_title
     * @return ProductModel
     */
    public function setSeoTitle(?string $seo_title): ProductModel
    {
        $this->seo_title = $seo_title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSeoDescription(): ?string
    {
        return $this->seo_description;
    }

    /**
     * @param string|null $seo_description
     * @return ProductModel
     */
    public function setSeoDescription(?string $seo_description): ProductModel
    {
        $this->seo_description = $seo_description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubCategory(): ?string
    {
        return $this->sub_category;
    }

    /**
     * @param string|null $sub_category
     * @return ProductModel
     */
    public function setSubCategory(?string $sub_category): ProductModel
    {
        $this->sub_category = $sub_category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return ProductModel
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param mixed $isVisible
     * @return ProductModel
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;
        return $this;
    }

}