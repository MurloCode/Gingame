<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Cet email est deja utilisé")
 * @Vich\Uploadable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private $login;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="createdBy")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity=Quizz::class, mappedBy="createdBy")
     */
    private $quizz;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="friends")
     */
    private $friends;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $Created_At;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageurl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

	/**
	 * @Vich\UploadableField(mapping="user_images", fileNameProperty="imageurl")
	 * @var File
	 */
	private $imageFile;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->quizz = new ArrayCollection();
        $this->friends = new ArrayCollection();
        $this->Created_At = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function __toString(){
        return $this->login;
        return $this->quizz;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $question->setCreatedBy($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getCreatedBy() === $this) {
                $question->setCreatedBy(null);
            }
        }

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
            $quizz->setCreatedBy($this);
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): self
    {
        if ($this->quizz->removeElement($quizz)) {
            // set the owning side to null (unless already changed)
            if ($quizz->getCreatedBy() === $this) {
                $quizz->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    public function addFriend(self $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
        }

        return $this;
    }

    public function removeFriend(self $friend): self
    {
        $this->friends->removeElement($friend);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->Created_At;
    }

    public function setCreatedAt(?\DateTimeInterface $Created_At): self
    {
        $this->Created_At = $Created_At;

        return $this;
    }

    public function getImageurl(): ?string
    {
        return $this->imageurl;
    }

    public function setImageurl(?string $imageurl): self
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

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

    // public function __serialize(): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'email' => $this->email,
    //         'login' => $this->login,
    //         'password' => $this->password,
    //         //......
    //     ];
    // }

    // public function __unserialize(array $serialized): User
    // {
    //     $this->id = $serialized['id'];
    //     $this->email = $serialized['email'];
    //     $this->login = $serialized['login'];
    //     $this->password = $serialized['password'];
    //     // .....
    //     return $this;
    // }
}
