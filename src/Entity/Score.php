<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="scores")
 */
class Score
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="scores")
     */
    private $player;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="scores")
     */
    private $game;


    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }
    public function getScore(): int
    {
        return $this->score;
    }
    
    public function setCreatedAt(DateTime $date): void
    {
        $this->created_at = $date;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }
    public function setPlayer(Player $player): void
    {
        $this->player = $player;
    }

    public function getGame(): Game
    {
        return $this->game;
    }
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }
}