<?php


namespace App\Model\OutputModel;


class ArticleModel
{
    private $id;
    private $image;
    private $title;
    private $short_description;
    private $description;
    private $seo_title;
    private $seo_description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ArticleModel
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return ArticleModel
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return ArticleModel
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortDescription()
    {
        return $this->short_description;
    }

    /**
     * @param mixed $short_description
     * @return ArticleModel
     */
    public function setShortDescription($short_description)
    {
        $this->short_description = $short_description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return ArticleModel
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    /**
     * @param mixed $seo_title
     * @return ArticleModel
     */
    public function setSeoTitle($seo_title)
    {
        $this->seo_title = $seo_title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSeoDescription()
    {
        return $this->seo_description;
    }

    /**
     * @param mixed $seo_description
     * @return ArticleModel
     */
    public function setSeoDescription($seo_description)
    {
        $this->seo_description = $seo_description;
        return $this;
    }


}