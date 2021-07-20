<?php

namespace App\Entity;

use App\Repository\QuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizzRepository::class)
 */
class Quizz
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
	private $name;    

	/**
	 * @ORM\Column(type="string", length=1000, nullable=true)
	 */
	private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, inversedBy="quizzs")
     */
    private $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

	public function __toString(){
		return $this->name;
	}

	



	public function getId(): ?int
                        	{
                        		return $this->id;
                        	}

	public function getName(): ?string
                        	{
                        		return $this->name;
                        	}

	public function setName(string $name): self
                        	{
                        		$this->name = $name;
                        
                        		return $this;
                        	}

	public function getDescription(): ?string
                        	{
                        		return $this->description;
                        	}

	public function setDescription(?string $description): self
                        	{
                        		$this->description = $description;
                        
                        		return $this;
                        	}

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        $this->questions->removeElement($question);

        return $this;
    }


}
