<?php


namespace App\Model\FormModel;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleModel
{
    /**
     * @var UploadedFile|null
     * @Assert\Image()
     */
    private $image;

    /** @var bool|null */
    private $is_visible;

    private $slug;

    private $title_RU;

    private $short_description_RU;
    /**
     * @Assert\NotBlank()
     */
    private $description_RU;

    private $seo_title_RU;

    private $seo_description_RU;

    private $title_EN;

    private $short_description_EN;
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
     * @return ArticleModel
     */
    public function setImage(?UploadedFile $image): ArticleModel
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    /**
     * @param bool $is_visible
     * @return ArticleModel
     */
    public function setIsVisible(?bool $is_visible): ArticleModel
    {
        $this->is_visible = $is_visible;
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
     * @return ArticleModel
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
     * @return ArticleModel
     */
    public function setTitleRU($title_RU)
    {
        $this->title_RU = $title_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortDescriptionRU()
    {
        return $this->short_description_RU;
    }

    /**
     * @param mixed $short_description_RU
     * @return ArticleModel
     */
    public function setShortDescriptionRU($short_description_RU)
    {
        $this->short_description_RU = $short_description_RU;
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
     * @return ArticleModel
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
     * @return ArticleModel
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
     * @return ArticleModel
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
     * @return ArticleModel
     */
    public function setTitleEN($title_EN)
    {
        $this->title_EN = $title_EN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortDescriptionEN()
    {
        return $this->short_description_EN;
    }

    /**
     * @param mixed $short_description_EN
     * @return ArticleModel
     */
    public function setShortDescriptionEN($short_description_EN)
    {
        $this->short_description_EN = $short_description_EN;
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
     * @return ArticleModel
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
     * @return ArticleModel
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
     * @return ArticleModel
     */
    public function setSeoDescriptionEN($seo_description_EN)
    {
        $this->seo_description_EN = $seo_description_EN;
        return $this;
    }

}