<?php

namespace App\DB\Entity;

use Doctrine\ORM\Mapping as ORM;

trait AutoIdEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
