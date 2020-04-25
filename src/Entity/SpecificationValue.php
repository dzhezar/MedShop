<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecificationValueRepository")
 */
class SpecificationValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specification", inversedBy="specificationValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpecificationValueTranslation", mappedBy="specification_value", cascade={"persist", "remove"})
     */
    private $specificationValueTranslations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="specificationValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function __construct()
    {
        $this->specificationValueTranslations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecification(): ?Specification
    {
        return $this->specification;
    }

    public function setSpecification(?Specification $specification): self
    {
        $this->specification = $specification;

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
            $specificationValueTranslation->setSpecificationValue($this);
        }

        return $this;
    }

    public function removeSpecificationValueTranslation(SpecificationValueTranslation $specificationValueTranslation): self
    {
        if ($this->specificationValueTranslations->contains($specificationValueTranslation)) {
            $this->specificationValueTranslations->removeElement($specificationValueTranslation);
            // set the owning side to null (unless already changed)
            if ($specificationValueTranslation->getSpecificationValue() === $this) {
                $specificationValueTranslation->setSpecificationValue(null);
            }
        }

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
