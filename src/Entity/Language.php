<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language implements EntityInterface
{
    const EN_LANGUAGE_NAME = 'en';
    const RU_LANGUAGE_NAME = 'ru';
    const LANGUAGES_ARRAY = [
        self::EN_LANGUAGE_NAME,
        self::RU_LANGUAGE_NAME
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $short_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryTranslation", mappedBy="language")
     */
    private $categoryTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductTranslation", mappedBy="language")
     */
    private $productTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpecificationTranslation", mappedBy="languge")
     */
    private $specificationTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpecificationValueTranslation", mappedBy="language")
     */
    private $specificationValueTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleTranslation", mappedBy="language")
     */
    private $articleTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MainPageSliderTranslation", mappedBy="language")
     */
    private $mainPageSliderTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="language")
     */
    private $orders;

    public function __construct()
    {
        $this->categoryTranslations = new ArrayCollection();
        $this->productTranslations = new ArrayCollection();
        $this->specificationTranslations = new ArrayCollection();
        $this->specificationValueTranslations = new ArrayCollection();
        $this->articleTranslations = new ArrayCollection();
        $this->mainPageSliderTranslations = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): self
    {
        $this->short_name = $short_name;

        return $this;
    }

    /**
     * @return Collection|CategoryTranslation[]
     */
    public function getCategoryTranslations(): Collection
    {
        return $this->categoryTranslations;
    }

    public function addCategoryTranslation(CategoryTranslation $categoryTranslation): self
    {
        if (!$this->categoryTranslations->contains($categoryTranslation)) {
            $this->categoryTranslations[] = $categoryTranslation;
            $categoryTranslation->setLanguage($this);
        }

        return $this;
    }

    public function removeCategoryTranslation(CategoryTranslation $categoryTranslation): self
    {
        if ($this->categoryTranslations->contains($categoryTranslation)) {
            $this->categoryTranslations->removeElement($categoryTranslation);
            // set the owning side to null (unless already changed)
            if ($categoryTranslation->getLanguage() === $this) {
                $categoryTranslation->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductTranslation[]
     */
    public function getProductTranslations(): Collection
    {
        return $this->productTranslations;
    }

    public function addProductTranslation(ProductTranslation $productTranslation): self
    {
        if (!$this->productTranslations->contains($productTranslation)) {
            $this->productTranslations[] = $productTranslation;
            $productTranslation->setLanguage($this);
        }

        return $this;
    }

    public function removeProductTranslation(ProductTranslation $productTranslation): self
    {
        if ($this->productTranslations->contains($productTranslation)) {
            $this->productTranslations->removeElement($productTranslation);
            // set the owning side to null (unless already changed)
            if ($productTranslation->getLanguage() === $this) {
                $productTranslation->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecificationTranslation[]
     */
    public function getSpecificationTranslations(): Collection
    {
        return $this->specificationTranslations;
    }

    public function addSpecificationTranslation(SpecificationTranslation $specificationTranslation): self
    {
        if (!$this->specificationTranslations->contains($specificationTranslation)) {
            $this->specificationTranslations[] = $specificationTranslation;
            $specificationTranslation->setLanguge($this);
        }

        return $this;
    }

    public function removeSpecificationTranslation(SpecificationTranslation $specificationTranslation): self
    {
        if ($this->specificationTranslations->contains($specificationTranslation)) {
            $this->specificationTranslations->removeElement($specificationTranslation);
            // set the owning side to null (unless already changed)
            if ($specificationTranslation->getLanguge() === $this) {
                $specificationTranslation->setLanguge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecificationValueTranslation[]
     */
    public function getSpecificationValueTranslations(): Collection
    {
        return $this->specificationValueTranslations;
    }

    public function addSpecificationValueTranslation(SpecificationValueTranslation $specificationValueTranslation): self
    {
        if (!$this->specificationValueTranslations->contains($specificationValueTranslation)) {
            $this->specificationValueTranslations[] = $specificationValueTranslation;
            $specificationValueTranslation->setLanguage($this);
        }

        return $this;
    }

    public function removeSpecificationValueTranslation(SpecificationValueTranslation $specificationValueTranslation): self
    {
        if ($this->specificationValueTranslations->contains($specificationValueTranslation)) {
            $this->specificationValueTranslations->removeElement($specificationValueTranslation);
            // set the owning side to null (unless already changed)
            if ($specificationValueTranslation->getLanguage() === $this) {
                $specificationValueTranslation->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleTranslation[]
     */
    public function getArticleTranslations(): Collection
    {
        return $this->articleTranslations;
    }

    public function addArticleTranslation(ArticleTranslation $articleTranslation): self
    {
        if (!$this->articleTranslations->contains($articleTranslation)) {
            $this->articleTranslations[] = $articleTranslation;
            $articleTranslation->setLanguage($this);
        }

        return $this;
    }

    public function removeArticleTranslation(ArticleTranslation $articleTranslation): self
    {
        if ($this->articleTranslations->contains($articleTranslation)) {
            $this->articleTranslations->removeElement($articleTranslation);
            // set the owning side to null (unless already changed)
            if ($articleTranslation->getLanguage() === $this) {
                $articleTranslation->setLanguage(null);
            }
        }

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
            $mainPageSliderTranslation->setLanguage($this);
        }

        return $this;
    }

    public function removeMainPageSliderTranslation(MainPageSliderTranslation $mainPageSliderTranslation): self
    {
        if ($this->mainPageSliderTranslations->contains($mainPageSliderTranslation)) {
            $this->mainPageSliderTranslations->removeElement($mainPageSliderTranslation);
            // set the owning side to null (unless already changed)
            if ($mainPageSliderTranslation->getLanguage() === $this) {
                $mainPageSliderTranslation->setLanguage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setLanguage($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getLanguage() === $this) {
                $order->setLanguage(null);
            }
        }

        return $this;
    }
}
