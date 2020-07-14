<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     denormalizationContext={
 *          "groups" = {"post"}
 *     },
 *     normalizationContext={
 *          "groups"={"annonce_read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"annonce_read", "user_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @ApiSubresource()
     * @Groups({"post", "annonce_read", "user_read"})
     * @Assert\Length(min="3", max="25", minMessage="Le titre du livre doit faire au moins 3 caractéres", maxMessage="Le titre du livre doit faire maximun 25 caractéres")
     * @Assert\NotBlank(message="Le titre est obligatoire")
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="annonce")
     * @ApiSubresource()
     * @Groups({"post", "annonce_read", "user_read"})
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post", "annonce_read", "user_read"})
     * @Assert\Length(min="3", max="25", minMessage="Le nom de la maison d'edition doit faire au moins 3 caractéres", maxMessage="Le nom de la maison d'edition doit faire maximun 25 caractéres")
     * @Assert\NotBlank(message="La maison d'édition est obligatoire")
     */
    private $houseEdition;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post", "annonce_read", "user_read"})
     * @Assert\NotBlank(message="L'année de parution est obligatoire")
     */
    private $yearParution;

    /**
     * @ORM\Column(type="text")
     * @Groups({"post", "annonce_read", "user_read"})
     * @Assert\Length(min="1", max="2000", minMessage="La description du livre doit faire au moins 1 caractéres", maxMessage="La description du livre doit faire maximun 2000 caractéres (environ 200 mots)")
     * @Assert\NotBlank(message="La description du livre est obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"post", "annonce_read"})
     * @Assert\Length(min="1", max="4000", minMessage="Les conditions pour le troc d'un ou plusieur livre(s) est obligatoire, elle doit faire au moins 15 caractéres", maxMessage="Les conditions pour le troc d'un ou plusieur livre(s) est obligatoire, elle doit faire au max 4000 caractéres")
     * @Assert\NotBlank(message="Les conditions pour le troc d'un ou plusieur livre(s) est obligatoire")
     */
    private $exigences;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @Groups({"post", "annonce_read"})
     */
    private $user;

    /**
     * @ORM\Column(type="json")
     * @Groups({"post", "annonce_read"})
     */
    private $category = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post", "annonce_read"})
     */
    private $district;


    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getHouseEdition()
    {
        return $this->houseEdition;
    }

    public function setHouseEdition(string $houseEdition): self
    {
        $this->houseEdition = $houseEdition;

        return $this;
    }

    public function getYearParution()
    {
        return $this->yearParution;
    }

    public function setYearParution(string $yearParution): self
    {
        $this->yearParution = $yearParution;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getExigences(): ?string
    {
        return $this->exigences;
    }

    public function setExigences(string $exigences): self
    {
        $this->exigences = $exigences;

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

    public function getCategory(): ?array
    {
        return $this->category;
    }

    public function setCategory(array $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(string $district): self
    {
        $this->district = $district;

        return $this;
    }


}
