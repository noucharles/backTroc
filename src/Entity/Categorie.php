<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"categorie_read"}
 *     }
 * )
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"annonce_read", "categorie_read"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonce_read", "categorie_read"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonce_read", "categorie_read"})
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"annonce_read", "categorie_read"})
     */
    private $backgroundColor;


    public function __construct()
    {
        $this->annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): self
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }


}
