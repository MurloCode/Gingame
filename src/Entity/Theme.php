<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeRepository::class)
 */
class Theme
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
	 * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="themes")
	 */
	private $themeParent;

	/**
	 * @ORM\ManyToMany(targetEntity=Theme::class, mappedBy="themeParent")
	 */
	private $themes;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Quizz::class, mappedBy="themes")
     */
    private $quizz;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, mappedBy="themes")
     */
    private $questions;

	public function __construct()
                              	{
                              		$this->themeParent = new ArrayCollection();
                              		$this->themes = new ArrayCollection();
                                $this->quizz = new ArrayCollection();
                                $this->questions = new ArrayCollection();
                              	}

	public function __toString()
                              	{
                              		return $this->name;
									return $this->quizz;
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

	/**
	 * @return Collection|self[]
	 */
	public function getThemeParent(): Collection
                              	{
                              		return $this->themeParent;
                              	}

	public function addThemeParent(self $themeParent): self
                              	{
                              		if (!$this->themeParent->contains($themeParent)) {
                              			$this->themeParent[] = $themeParent;
                              		}
                              
                              		return $this;
                              	}

	public function removeThemeParent(self $themeParent): self
                              	{
                              		$this->themeParent->removeElement($themeParent);
                              
                              		return $this;
                              	}

	/**
	 * @return Collection|self[]
	 */
	public function getThemes(): Collection
                              	{
                              		return $this->themes;
                              	}

	public function addTheme(self $theme): self
                              	{
                              		if (!$this->themes->contains($theme)) {
                              			$this->themes[] = $theme;
                              			$theme->addThemeParent($this);
                              		}
                              
                              		return $this;
                              	}

	public function removeTheme(self $theme): self
                              	{
                              		if ($this->themes->removeElement($theme)) {
                              			$theme->removeThemeParent($this);
                              		}
                              
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
     * @return Collection|Quizz[]
     */
    public function getQuizz(): Collection
    {
        return $this->quizz;
    }

    public function addQuizz(Quizz $quizz): self
    {
        if (!$this->quizz->contains($quizz)) {
            $this->quizz[] = $quizz;
            $quizz->addTheme($this);
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): self
    {
        if ($this->quizz->removeElement($quizz)) {
            $quizz->removeTheme($this);
        }

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
            $question->addTheme($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            $question->removeTheme($this);
        }

        return $this;
    }
}
