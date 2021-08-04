<?php

namespace App\Entity;

use App\Repository\QuizzRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=QuizzRepository::class)
 * @Vich\Uploadable
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
	 * @ORM\ManyToMany(targetEntity=Question::class, inversedBy="quizzs", cascade={"persist"})
	 */
	private $questions;

	/**
	 * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="quizz")
	 */
	private $themes;

	/**
	 * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quizz")
	 */
	private $createdBy;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $image;

	/**
	 * @Vich\UploadableField(mapping="quizz_images", fileNameProperty="image")
	 * @var File
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $updatedAt;

	public function __construct()
	{
		$this->questions = new ArrayCollection();
		$this->themes = new ArrayCollection();
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
	}

	public function __toString()
	{
		return $this->name;
		return $this->questions;
		return $this->themes;
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

	public function countQuestions(): int 
						   	{
						   		return $this->questions->count();
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

	/**
	 * @return Collection|Theme[]
	 */
	public function getThemes(): Collection
	{
		return $this->themes;
	}

	public function addTheme(Theme $theme): self
	{
		if (!$this->themes->contains($theme)) {
			$this->themes[] = $theme;
		}

		return $this;
	}

	public function removeTheme(Theme $theme): self
	{
		$this->themes->removeElement($theme);

		return $this;
	}

	public function getCreatedBy(): ?User
	{
		return $this->createdBy;
	}

	public function setCreatedBy(?User $createdBy): self
	{
		$this->createdBy = $createdBy;

		return $this;
	}

	public function getImage(): ?string
	{
		return $this->image;
	}

	public function setImage(?string $image): self
	{
		$this->image = $image;

		return $this;
	}
	
	public function setImageFile(File $file = null)
	{
		$this->imageFile = $file;
		if ($file) {
			$this->updatedAt = new \DateTime('now');
		}
	}

	public function getImageFile()
	{
		return $this->imageFile;
	}

	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTimeInterface $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt(): ?\DateTimeInterface
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

}
