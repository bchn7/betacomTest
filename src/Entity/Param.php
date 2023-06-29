<?php

namespace App\Entity;
use App\Entity\Exam;

use App\Repository\ParamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParamRepository::class)]
class Param
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'params')]
    public ?Exam $exam_id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column]
    public ?float $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExamId(): ?Exam
    {
        return $this->exam_id;
    }

    public function setExamId(?Exam $exam_id): static
    {
        $this->exam_id = $exam_id;

        return $this;
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function __toString()
{
    return (string) $this->getExamId();
}
}
