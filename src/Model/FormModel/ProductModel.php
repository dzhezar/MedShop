<?php


namespace App\Model\FormModel;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ProductModel
{
    /**
     * @var UploadedFile|null
     * @Assert\Image()
     */
    private $image;

    /** @var bool|null */
    private $isVisible;

    /** @var bool|null */
    private $isOnMain;

    private $slug;

    /**
     * @var float|null
     * @Assert\Type(type="float", message="Цена должна быть формата '15.45'")
     */

    private $price;

    /** @var Category|null */
    private $category;

    private $relatedProducts;

    private $title_RU;

    /**
     * @Assert\NotBlank()
     */
    private $description_RU;

    /**
     * @Assert\NotBlank()
     */
    private $usageDescription_RU;

    private $seoTitle_RU;

    private $seoDescription_RU;

    private $title_EN;

    /**
     * @Assert\NotBlank()
     */
    private $description_EN;

    /**
     * @Assert\NotBlank()
     */
    private $usageDescription_EN;

    private $seoTitle_EN;

    private $seoDescription_EN;

    private $specifications;

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    /**
     * @param UploadedFile|null $image
     * @return ProductModel
     */
    public function setImage(?UploadedFile $image): ProductModel
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    /**
     * @param bool|null $isVisible
     * @return ProductModel
     */
    public function setIsVisible(?bool $isVisible): ProductModel
    {
        $this->isVisible = $isVisible;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsOnMain(): ?bool
    {
        return $this->isOnMain;
    }

    /**
     * @param bool|null $isOnMain
     * @return ProductModel
     */
    public function setIsOnMain(?bool $isOnMain): ProductModel
    {
        $this->isOnMain = $isOnMain;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return ProductModel
     */
    public function setPrice(?float $price): ProductModel
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return ProductModel
     */
    public function setCategory(?Category $category): ProductModel
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitleRU()
    {
        return $this->title_RU;
    }

    /**
     * @param mixed $title_RU
     * @return ProductModel
     */
    public function setTitleRU($title_RU)
    {
        $this->title_RU = $title_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescriptionRU()
    {
        return $this->description_RU;
    }

    /**
     * @param mixed $description_RU
     * @return ProductModel
     */
    public function setDescriptionRU($description_RU)
    {
        $this->description_RU = $description_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsageDescriptionRU()
    {
        return $this->usageDescription_RU;
    }

    /**
     * @param mixed $usageDescription_RU
     * @return ProductModel
     */
    public function setUsageDescriptionRU($usageDescription_RU)
    {
        $this->usageDescription_RU = $usageDescription_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoTitleRU()
    {
        return $this->seoTitle_RU;
    }

    /**
     * @param mixed $seoTitle_RU
     * @return ProductModel
     */
    public function setSeoTitleRU($seoTitle_RU)
    {
        $this->seoTitle_RU = $seoTitle_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoDescriptionRU()
    {
        return $this->seoDescription_RU;
    }

    /**
     * @param mixed $seoDescription_RU
     * @return ProductModel
     */
    public function setSeoDescriptionRU($seoDescription_RU)
    {
        $this->seoDescription_RU = $seoDescription_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitleEN()
    {
        return $this->title_EN;
    }

    /**
     * @param mixed $title_EN
     * @return ProductModel
     */
    public function setTitleEN($title_EN)
    {
        $this->title_EN = $title_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescriptionEN()
    {
        return $this->description_EN;
    }

    /**
     * @param mixed $description_EN
     * @return ProductModel
     */
    public function setDescriptionEN($description_EN)
    {
        $this->description_EN = $description_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsageDescriptionEN()
    {
        return $this->usageDescription_EN;
    }

    /**
     * @param mixed $usageDescription_EN
     * @return ProductModel
     */
    public function setUsageDescriptionEN($usageDescription_EN)
    {
        $this->usageDescription_EN = $usageDescription_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoTitleEN()
    {
        return $this->seoTitle_EN;
    }

    /**
     * @param mixed $seoTitle_EN
     * @return ProductModel
     */
    public function setSeoTitleEN($seoTitle_EN)
    {
        $this->seoTitle_EN = $seoTitle_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoDescriptionEN()
    {
        return $this->seoDescription_EN;
    }

    /**
     * @param mixed $seoDescription_EN
     * @return ProductModel
     */
    public function setSeoDescriptionEN($seoDescription_EN)
    {
        $this->seoDescription_EN = $seoDescription_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }

    /**
     * @param $relatedProducts
     * @return ProductModel
     */
    public function setRelatedProducts($relatedProducts): ProductModel
    {
        $this->relatedProducts = $relatedProducts;
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
    public function getSpecifications()
    {
        return $this->specifications;
    }

    /**
     * @param mixed $specifications
     * @return ProductModel
     */
    public function setSpecifications($specifications)
    {
        $this->specifications = $specifications;
        return $this;
    }

}