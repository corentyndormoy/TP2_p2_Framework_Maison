<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 * @ORM\Table(name="games")=
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Player", mappedBy="games")
     */
    private $players;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Score", mappedBy="game")
     */
    private $scores;


    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function getImage(): string
    {
        return $this->image;
    }

    public function addScore(Score $score): void
    {
        $this->scores[] = $score;
    }
    public function getScores(): array
    {
        return $this->scores;
    }
}