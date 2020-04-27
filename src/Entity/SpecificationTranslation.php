<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecificationTranslationRepository")
 */
class SpecificationTranslation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Specification", inversedBy="specificationTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="specificationTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $languge;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLanguge(): ?Language
    {
        return $this->languge;
    }

    public function setLanguge(?Language $languge): self
    {
        $this->languge = $languge;

        return $this;
    }
}
