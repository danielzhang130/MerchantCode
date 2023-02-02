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
class Category
{
    use AutoIdEntity;
    use TimeStampedEntity;

    /**
     * @ORM\Column(type="text")
     */
    public string $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity=SubCategory::class,
     *     mappedBy="category",
     *     cascade={"remove"}
     * )
     */
    public Collection $subCategories;

    /**
     * @param string $name
     * @param Collection $subCategories
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
     * @return Collection
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    /**
     * @param Collection $subCategories
     */
    public function setSubCategories(Collection $subCategories): void
    {
        $this->subCategories = $subCategories;
    }
}