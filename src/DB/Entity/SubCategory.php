<?php

namespace App\DB\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity
 * @ORM\Table
 * @HasLifecycleCallbacks
 */
class SubCategory
{
    use AutoIdEntity;
    use TimeStampedEntity;

    /**
     * @ORM\Column(type="text")
     */
    public string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    public Category $category;

    /**
     * @ORM\OneToMany(targetEntity=Merchant::class, mappedBy="subCategory", cascade={"remove"})
     */
    public Collection $merchants;

    /**
     * @param string $name
     * @param Category $category
     * @param Collection $merchants
     */
    public function __construct(string $name, Category $category)
    {
        $this->name = $name;
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Collection
     */
    public function getMerchants(): Collection
    {
        return $this->merchants;
    }

    /**
     * @param Collection $merchants
     */
    public function setMerchants(Collection $merchants): void
    {
        $this->merchants = $merchants;
    }
}