<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="products")
     */
    private $related_products;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="related_products")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductTranslation", mappedBy="product")
     */
    private $productTranslations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Specification", mappedBy="product")
     */
    private $specifications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SpecificationValue", mappedBy="product")
     */
    private $specificationValues;

    public function __construct()
    {
        $this->related_products = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->productTranslations = new ArrayCollection();
        $this->specifications = new ArrayCollection();
        $this->specificationValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRelatedProducts(): Collection
    {
        return $this->related_products;
    }

    public function addRelatedProduct(self $relatedProduct): self
    {
        if (!$this->related_products->contains($relatedProduct)) {
            $this->related_products[] = $relatedProduct;
        }

        return $this;
    }

    public function removeRelatedProduct(self $relatedProduct): self
    {
        if ($this->related_products->contains($relatedProduct)) {
            $this->related_products->removeElement($relatedProduct);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(self $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addRelatedProduct($this);
        }

        return $this;
    }

    public function removeProduct(self $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeRelatedProduct($this);
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
            $productTranslation->setProduct($this);
        }

        return $this;
    }

    public function removeProductTranslation(ProductTranslation $productTranslation): self
    {
        if ($this->productTranslations->contains($productTranslation)) {
            $this->productTranslations->removeElement($productTranslation);
            // set the owning side to null (unless already changed)
            if ($productTranslation->getProduct() === $this) {
                $productTranslation->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Specification[]
     */
    public function getSpecifications(): Collection
    {
        return $this->specifications;
    }

    public function addSpecification(Specification $specification): self
    {
        if (!$this->specifications->contains($specification)) {
            $this->specifications[] = $specification;
            $specification->setProduct($this);
        }

        return $this;
    }

    public function removeSpecification(Specification $specification): self
    {
        if ($this->specifications->contains($specification)) {
            $this->specifications->removeElement($specification);
            // set the owning side to null (unless already changed)
            if ($specification->getProduct() === $this) {
                $specification->setProduct(null);
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
            $specificationValue->setProduct($this);
        }

        return $this;
    }

    public function removeSpecificationValue(SpecificationValue $specificationValue): self
    {
        if ($this->specificationValues->contains($specificationValue)) {
            $this->specificationValues->removeElement($specificationValue);
            // set the owning side to null (unless already changed)
            if ($specificationValue->getProduct() === $this) {
                $specificationValue->setProduct(null);
            }
        }

        return $this;
    }
}
