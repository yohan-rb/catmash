<?php

namespace App\Entity;

use App\Repository\CatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CatRepository::class)
 */
class Cat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $isActive;

    /**
     * @ORM\Column(type="bigint", options={"default" : 0})
     */
    private $viewedCount;

    /**
     * @ORM\Column(type="bigint", options={"default" : 0})
     */
    private $votedCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getViewedCount(): ?int
    {
        return $this->viewedCount;
    }

    public function setViewedCount(int $viewedCount): self
    {
        $this->viewedCount = $viewedCount;

        return $this;
    }

    public function getVotedCount(): ?int
    {
        return $this->votedCount;
    }

    public function setVotedCount(int $votedCount): self
    {
        $this->votedCount = $votedCount;

        return $this;
    }
}
