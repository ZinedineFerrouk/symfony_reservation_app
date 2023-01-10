<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SalleRepository::class)]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 58,
        minMessage:'Veuillez saisir un nom de salle avec plus de caractères',
        maxMessage:'Veuillez saisir un nom de salle avec moins de caractères',
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 500,
        minMessage:'Veuillez saisir un contenu avec plus de caractères',
        maxMessage:'Veuillez saisir un contenu avec moins de caractères',
    )]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getInfos(): array
    {
        return array(
            'id'      => $this->getId(),
            'title'   => $this->getTitle(),
            'content' => $this->getContent(),
        );
    }
}
