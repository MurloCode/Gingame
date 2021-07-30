<?php

namespace App\Entity;

use App\Repository\HistoricRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoricRepository::class)
 */
class Historic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Quizz::class, inversedBy="historics")
     */
    private $quizz;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historics")
     */
    private $user;

    /**
     * @ORM\Column(type="smallint")
     */
    private $score;

    /**
     * @ORM\Column(type="smallint")
     */
    private $outOf;

    /**
     * @ORM\Column(type="datetime")
     */
    private $playedAt;

    public function __construct() {
        $this->playedAt = new DateTime(); 
    }

    public function __toString(){
        return $this->playedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizz(): ?Quizz
    {
        return $this->quizz;
    }

    public function setQuizz(?Quizz $quizz): self
    {
        $this->quizz = $quizz;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getOutOf(): ?int
    {
        return $this->outOf;
    }

    public function setOutOf(int $outOf): self
    {
        $this->outOf = $outOf;

        return $this;
    }

    public function getPlayedAt(): ?\DateTimeInterface
    {
        return $this->playedAt; 
    }

    public function setPlayedAt(\DateTimeInterface $playedAt): self
    {
        $this->playedAt = $playedAt;

        return $this;
    }
}
