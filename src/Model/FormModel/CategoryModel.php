<?php


namespace App\Model\FormModel;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryModel
{
    /** @var UploadedFile|null */
    private $image;

    private $slug;

    /** @var Category|null */
    private $category;

    private $title_RU;

    /**
     * @Assert\NotBlank()
     */
    private $description_RU;
    private $seo_title_RU;
    private $seo_description_RU;

    private $title_EN;

    /**
     * @Assert\NotBlank()
     */
    private $description_EN;
    private $seo_title_EN;
    private $seo_description_EN;

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    /**
     * @param UploadedFile|null $image
     * @return CategoryModel
     */
    public function setImage(?UploadedFile $image): CategoryModel
    {
        $this->image = $image;
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
     * @return CategoryModel
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * @return CategoryModel
     */
    public function setCategory(?Category $category): CategoryModel
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
     * @return CategoryModel
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
     * @return CategoryModel
     */
    public function setDescriptionRU($description_RU)
    {
        $this->description_RU = $description_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoTitleRU()
    {
        return $this->seo_title_RU;
    }

    /**
     * @param mixed $seo_title_RU
     * @return CategoryModel
     */
    public function setSeoTitleRU($seo_title_RU)
    {
        $this->seo_title_RU = $seo_title_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoDescriptionRU()
    {
        return $this->seo_description_RU;
    }

    /**
     * @param mixed $seo_description_RU
     * @return CategoryModel
     */
    public function setSeoDescriptionRU($seo_description_RU)
    {
        $this->seo_description_RU = $seo_description_RU;
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
     * @return CategoryModel
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
     * @return CategoryModel
     */
    public function setDescriptionEN($description_EN)
    {
        $this->description_EN = $description_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoTitleEN()
    {
        return $this->seo_title_EN;
    }

    /**
     * @param mixed $seo_title_EN
     * @return CategoryModel
     */
    public function setSeoTitleEN($seo_title_EN)
    {
        $this->seo_title_EN = $seo_title_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoDescriptionEN()
    {
        return $this->seo_description_EN;
    }

    /**
     * @param mixed $seo_description_EN
     * @return CategoryModel
     */
    public function setSeoDescriptionEN($seo_description_EN)
    {
        $this->seo_description_EN = $seo_description_EN;
        return $this;
    }




}