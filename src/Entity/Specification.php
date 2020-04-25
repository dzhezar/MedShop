<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecificationRepository")
 */
class Specification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpecificationTranslation", mappedBy="specification")
     */
    private $specificationTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpecificationValue", mappedBy="specification")
     */
    private $specificationValues;

    public function __construct()
    {
        $this->specificationTranslations = new ArrayCollection();
        $this->specificationValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $specificationTranslation->setSpecification($this);
        }

        return $this;
    }

    public function removeSpecificationTranslation(SpecificationTranslation $specificationTranslation): self
    {
        if ($this->specificationTranslations->contains($specificationTranslation)) {
            $this->specificationTranslations->removeElement($specificationTranslation);
            // set the owning side to null (unless already changed)
            if ($specificationTranslation->getSpecification() === $this) {
                $specificationTranslation->setSpecification(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecificationValue[]
     */
    public function getSpecificationValues(): Collection
    {
        return $this->specificationValues;
    }

    public function addSpecificationValue(SpecificationValue $specificationValue): self
    {
        if (!$this->specificationValues->contains($specificationValue)) {
            $this->specificationValues[] = $specificationValue;
            $specificationValue->setSpecification($this);
        }

        return $this;
    }

    public function removeSpecificationValue(SpecificationValue $specificationValue): self
    {
        if ($this->specificationValues->contains($specificationValue)) {
            $this->specificationValues->removeElement($specificationValue);
            // set the owning side to null (unless already changed)
            if ($specificationValue->getSpecification() === $this) {
                $specificationValue->setSpecification(null);
            }
        }

        return $this;
    }
}
