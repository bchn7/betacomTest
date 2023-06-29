<?php

namespace App\Entity;

use App\Repository\ExamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamRepository::class)]
class Exam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $createDt = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'exam_id', targetEntity: Param::class)]
    public Collection $params;

    public function __construct()
    {
        $this->params = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreateDt(): ?\DateTimeInterface
    {
        return $this->createDt;
    }

    public function setCreateDt(\DateTimeInterface $createDt): static
    {
        $this->createDt = $createDt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Param>
     */
    public function getParams(): Collection
    {
        return $this->params;
    }

    public function addParam(Param $param): static
    {
        if (!$this->params->contains($param)) {
            $this->params->add($param);
            $param->setExamId($this);
        }

        return $this;
    }

    public function removeParam(Param $param): static
    {
        if ($this->params->removeElement($param)) {
            // set the owning side to null (unless already changed)
            if ($param->getExamId() === $this) {
                $param->setExamId(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
