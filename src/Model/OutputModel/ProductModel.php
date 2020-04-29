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

    private $usage;

    /** @var string|null */
    private $seo_title;

    /** @var string|null */
    private $seo_description;


    private $price;

    private $isVisible;

    private $inCart;

    private $cartAmount;

    private $slug;

    private $category;

    private $sub_category;

    private $related_products;

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

    /**
     * @return mixed
     */
    public function getInCart()
    {
        return $this->inCart;
    }

    /**
     * @param mixed $inCart
     * @return ProductModel
     */
    public function setInCart($inCart)
    {
        $this->inCart = $inCart;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCartAmount()
    {
        return $this->cartAmount;
    }

    /**
     * @param mixed $cartAmount
     * @return ProductModel
     */
    public function setCartAmount($cartAmount)
    {
        $this->cartAmount = $cartAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return ProductModel
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return ProductModel
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->sub_category;
    }

    /**
     * @param mixed $sub_category
     * @return ProductModel
     */
    public function setSubCategory($sub_category)
    {
        $this->sub_category = $sub_category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelatedProducts()
    {
        return $this->related_products;
    }

    /**
     * @param mixed $related_products
     * @return ProductModel
     */
    public function setRelatedProducts($related_products)
    {
        $this->related_products = $related_products;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param mixed $usage
     * @return ProductModel
     */
    public function setUsage($usage)
    {
        $this->usage = $usage;
        return $this;
    }



}