<?php

namespace App\DB\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity
 * @ORM\Table
 * @HasLifecycleCallbacks
 */
class Merchant
{
    use AutoIdEntity;
    use TimeStampedEntity;

    /**
     * @ORM\Column(type="text")
     */
    public string $name;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class)
     */
    public SubCategory $subCategory;

    /**
     * @param string $name
     * @param SubCategory $subCategory
     */
    public function __construct(string $name, SubCategory $subCategory)
    {
        $this->name = $name;
        $this->subCategory = $subCategory;
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
     * @return SubCategory
     */
    public function getSubCategory(): SubCategory
    {
        return $this->subCategory;
    }

    /**
     * @param SubCategory $subCategory
     */
    public function setSubCategory(SubCategory $subCategory): void
    {
        $this->subCategory = $subCategory;
    }
}