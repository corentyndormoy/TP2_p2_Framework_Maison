<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @ORM\Table(name="players")
 */
class Player
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
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Game", inversedBy="players")
     */
    private $games;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Score", mappedBy="player")
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

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function getUsername(): string
    {
        return $this->username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function addGame(Game $game): void
    {
        $this->games[] = $game;
    }
    public function getGames(): array
    {
        return $this->games;
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