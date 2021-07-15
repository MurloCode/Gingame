<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
    private $question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $right_text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $right_elem;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wrong_text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wrong_elem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getRightText(): ?string
    {
        return $this->right_text;
    }

    public function setRightText(string $right_text): self
    {
        $this->right_text = $right_text;

        return $this;
    }

    public function getRightElem(): ?string
    {
        return $this->right_elem;
    }

    public function setRightElem(string $right_elem): self
    {
        $this->right_elem = $right_elem;

        return $this;
    }

    public function getWrongText(): ?string
    {
        return $this->wrong_text;
    }

    public function setWrongText(string $wrong_text): self
    {
        $this->wrong_text = $wrong_text;

        return $this;
    }

    public function getWrongElem(): ?string
    {
        return $this->wrong_elem;
    }

    public function setWrongElem(string $wrong_elem): self
    {
        $this->wrong_elem = $wrong_elem;

        return $this;
    }
}
