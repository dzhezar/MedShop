<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainPageSliderRepository")
 */
class MainPageSlider
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MainPageSliderTranslation", mappedBy="main_page_slider")
     */
    private $mainPageSliderTranslations;

    public function __construct()
    {
        $this->mainPageSliderTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|MainPageSliderTranslation[]
     */
    public function getMainPageSliderTranslations(): Collection
    {
        return $this->mainPageSliderTranslations;
    }

    public function addMainPageSliderTranslation(MainPageSliderTranslation $mainPageSliderTranslation): self
    {
        if (!$this->mainPageSliderTranslations->contains($mainPageSliderTranslation)) {
            $this->mainPageSliderTranslations[] = $mainPageSliderTranslation;
            $mainPageSliderTranslation->setMainPageSlider($this);
        }

        return $this;
    }

    public function removeMainPageSliderTranslation(MainPageSliderTranslation $mainPageSliderTranslation): self
    {
        if ($this->mainPageSliderTranslations->contains($mainPageSliderTranslation)) {
            $this->mainPageSliderTranslations->removeElement($mainPageSliderTranslation);
            // set the owning side to null (unless already changed)
            if ($mainPageSliderTranslation->getMainPageSlider() === $this) {
                $mainPageSliderTranslation->setMainPageSlider(null);
            }
        }

        return $this;
    }
}
