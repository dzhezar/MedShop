<?php


namespace App\Model\OutputModel;


class CategoryModel
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

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return CategoryModel
     */
    public function setId(?int $id): CategoryModel
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
     * @return CategoryModel
     */
    public function setTitle(?string $title): CategoryModel
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
     * @return CategoryModel
     */
    public function setImage(?string $image): CategoryModel
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
     * @return CategoryModel
     */
    public function setDescription(?string $description): CategoryModel
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
     * @return CategoryModel
     */
    public function setSeoTitle(?string $seo_title): CategoryModel
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
     * @return CategoryModel
     */
    public function setSeoDescription(?string $seo_description): CategoryModel
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
     * @return CategoryModel
     */
    public function setSubCategory(?string $sub_category): CategoryModel
    {
        $this->sub_category = $sub_category;
        return $this;
    }


}