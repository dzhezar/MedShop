<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecificationValueTranslationRepository")
 */
class SpecificationValueTranslation
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="specificationValueTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SpecificationValue", inversedBy="specificationValueTranslations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specification_value;

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

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getSpecificationValue(): ?SpecificationValue
    {
        return $this->specification_value;
    }

    public function setSpecificationValue(?SpecificationValue $specification_value): self
    {
        $this->specification_value = $specification_value;

        return $this;
    }
}
