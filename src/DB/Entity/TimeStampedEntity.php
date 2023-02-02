<?php

namespace App\DB\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait TimeStampedEntity
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $last_modified_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $created_at;

    public function getLastModifiedAt(): DateTime
    {
        return $this->last_modified_at;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     *
     * @throws Exception
     */
    public function initTimestamps(): void
    {
        $this->last_modified_at = new DateTime();
        $this->created_at = $this->last_modified_at;
    }

    /**
     * @ORM\PreUpdate
     *
     * @throws Exception
     */
    public function preUpdate(): void
    {
        $this->last_modified_at = new DateTime();
    }
}
