<?php

namespace App\Entity\Traits;

use App\Entity\Category;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\Persistence\Event\LifecycleEventArgs;

trait HasTimestamps
{

    #[Column(name: 'created_at')]
    private DateTime $createdAt;

    #[Column(name: 'updated_at')]
    private DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Category
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): Category
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[PrePersist]
    public function updateTimestamps(LifecycleEventArgs $args): void
    {
        $time = new DateTime();

        if (!isset($this->createdAt)) {
            $this->createdAt = $time;
        }

        $this->updatedAt = $time;
    }

}
