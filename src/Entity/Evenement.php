<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;



/**
 * Evenement
 *
 * @ORM\Table(name="Evenement", indexes={@ORM\Index(name="FK_100", columns={"idc"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le champs nom est obligatoire * ")
     * @Assert\Length( min = 3, max = 20, minMessage = "Merci de Vérifier Votre nom")
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
    
     * @Assert\Length( min = 5, max = 20, minMessage = "Merci de Vérifier Votre type d'evenement ") 
     * @Assert\NotBlank(message="Le champs type est obligatoire * ")
     * @ORM\Column(type="string", length=255)
     */
    private $typeE;

    /**
    
     
     * @ORM\Column(type="date"))

     */
    private $date_debut;

    /**
    

    * @Assert\NotBlank(message="Le champs date est obligatoire * ")
     * @ORM\Column(type="date")
    
     */
    private $date_fin;

    /**
     
     * @Assert\NotBlank(message="Le champs date est obligatoire * ")
     * @ORM\Column(type="text") 
     */
    private $description;

    /**
    
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Profil::class, mappedBy="evenement")
     */
    private $profils;

   /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idc", referencedColumnName="id")
     * })
     */
    private $idc;

   


    public function __construct()
    {
        $this->profils = new ArrayCollection();
    }

 

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeE(): ?string
    {
        return $this->typeE;
    }

    public function setTypeE(string $typeE): self
    {
        $this->typeE = $typeE;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Profil[]
     */
    public function getProfils(): Collection
    {
        return $this->profils;
    }

    public function addProfil(Profil $profil): self
    {
        if (!$this->profils->contains($profil)) {
            $this->profils[] = $profil;
            $profil->setEvenement($this);
        }

        return $this;
    }

    public function removeProfil(Profil $profil): self
    {
        if ($this->profils->removeElement($profil)) {
            // set the owning side to null (unless already changed)
            if ($profil->getEvenement() === $this) {
                $profil->setEvenement(null);
            }
        }

        return $this;
    }

    public function  __toString(): ?string
    {
        return $this->id;
        }

    public function getIdc(): ?Category
    {
        return $this->idc;
    }

    public function setIdc(?Category $idc): self
    {
        $this->idc = $idc;

        return $this;
    }

  
    
   

   
}
