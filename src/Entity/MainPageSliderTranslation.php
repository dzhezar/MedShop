<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainPageSliderTranslationRepository")
 */
class MainPageSliderTranslation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MainPageSlider", inversedBy="mainPageSliderTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $main_page_slider;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="mainPageSliderTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainPageSlider(): ?MainPageSlider
    {
        return $this->main_page_slider;
    }

    public function setMainPageSlider(?MainPageSlider $main_page_slider): self
    {
        $this->main_page_slider = $main_page_slider;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }
}
