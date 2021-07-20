<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $right_text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $right_elem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wrong_text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wrong_elem;

    /**
     * @ORM\OneToMany(targetEntity=Proposition::class, mappedBy="question")
     */
    private $propositions;

    /**
     * @ORM\ManyToMany(targetEntity=Quizz::class, mappedBy="questions")
     */
    private $quizzs;

    public function __construct()
    {
        $this->propositions = new ArrayCollection();
        $this->quizzs = new ArrayCollection();
    }

    public function __toString(){
		return $this->question;
	}

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

    /**
     * @return Collection|Proposition[]
     */
    public function getPropositions(): Collection
    {
        return $this->propositions;
    }

    public function addProposition(Proposition $proposition): self
    {
        if (!$this->propositions->contains($proposition)) {
            $this->propositions[] = $proposition;
            $proposition->setQuestion($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): self
    {
        if ($this->propositions->removeElement($proposition)) {
            // set the owning side to null (unless already changed)
            if ($proposition->getQuestion() === $this) {
                $proposition->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quizz[]
     */
    public function getQuizzs(): Collection
    {
        return $this->quizzs;
    }

    public function addQuizz(Quizz $quizz): self
    {
        if (!$this->quizzs->contains($quizz)) {
            $this->quizzs[] = $quizz;
            $quizz->addQuestion($this);
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): self
    {
        if ($this->quizzs->removeElement($quizz)) {
            $quizz->removeQuestion($this);
        }

        return $this;
    }
}
