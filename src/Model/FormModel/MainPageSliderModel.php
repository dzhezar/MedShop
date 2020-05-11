<?php


namespace App\Model\FormModel;


use Symfony\Component\Validator\Constraints as Assert;

class MainPageSliderModel
{
    private $image;
    /**
     * @Assert\NotBlank()
     */
    private $text_RU;
    /**
     * @Assert\NotBlank()
     */
    private $text_EN;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return MainPageSliderModel
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextRU()
    {
        return $this->text_RU;
    }

    /**
     * @param mixed $text_RU
     * @return MainPageSliderModel
     */
    public function setTextRU($text_RU)
    {
        $this->text_RU = $text_RU;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextEN()
    {
        return $this->text_EN;
    }

    /**
     * @param mixed $text_EN
     * @return MainPageSliderModel
     */
    public function setTextEN($text_EN)
    {
        $this->text_EN = $text_EN;
        return $this;
    }
}