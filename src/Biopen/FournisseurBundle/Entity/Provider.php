<?php

namespace Biopen\FournisseurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity(repositoryClass="Biopen\FournisseurBundle\Repository\ProviderRepository")
 */
class Provider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * 
     *
     * @ORM\Column(type="point", name="latlng")
     */
    private $latlng;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
    * @ORM\OneToMany(targetEntity="Biopen\FournisseurBundle\Entity\ProviderProduct", mappedBy="provider", cascade={"persist", "remove"}, orphanRemoval=true)
    */
    private $products; 

    /**
     * @var string
     *
     * @ORM\Column(name="mainProduct", type="text", nullable=false)
     */
    private $mainProduct;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="horaires", type="object", nullable=true)
     */
    private $horaires;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="contributeur", type="string", length=255)
     */
    private $contributeur;

    /**
     * @var string
     *
     * @ORM\Column(name="contributeur_mail", type="string", length=255)
     */
    private $contributeurMail;

    /**
     * @var string
     *
     * @ORM\Column(name="validation_code", type="string", length=255)
     */
    private $validationCode;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide = false;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="contactAmap", type="object", nullable=true)
     */
    private $contactAmap;


    private $distance;

    private $wastedDistance;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->validationCode = md5(uniqid(rand(), true));
        $this->contributeur = '';
    }

    public function reinitContributor()
    {
        $this->validationCode = md5(uniqid(rand(), true));
        $this->contributeurMail = '';
        $this->contributeur = '';
    }

    public function resetProducts()
    {
        $this->productsCopy = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products->clear();
    }

    private function calculateWastedDistance()
    {
        if ( count($this->getProducts()) == 0 || in_array($this->getType(), array("epicerie","marche","boutique") )) return $this->getDistance();
        //$waste = 1.0 / pow(count($this->getProducts()),2);
        $waste = -1.0*count($this->getProducts())/10.0 + 1.0;
        return $this->getDistance() * $waste;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param float $distance
     *
     * @return Provider
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
        $this->wastedDistance = $this->calculateWastedDistance();

        return $this;
    }

    /**
     * Get id
     *
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set name
     *
     * @param float $distance
     *
     * @return Provider
     */
    public function setWastedDistance($distance)
    {
        $this->wastedDistance = $distance;

        return $this;
    }

    /**
     * Get id
     *
     * @return float
     */
    public function getWastedDistance()
    {
        return $this->wastedDistance;
    }

    /**
     * Set name
     *
     * @param string $distance
     *
     * @return Provider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Provider
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Provider
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Provider
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set products
     *
     * @param array $products
     *
     * @return Provider
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set horaires
     *
     * @param \stdClass $horaires
     *
     * @return Provider
     */
    public function setHoraires($horaires)
    {
        $this->horaires = $horaires;

        return $this;
    }

    /**
     * Get horaires
     *
     * @return \stdClass
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Provider
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set contributeur
     *
     * @param string $contributeur
     *
     * @return Provider
     */
    public function setContributeur($contributeur)
    {
        $this->contributeur = $contributeur;

        return $this;
    }

    /**
     * Get contributeur
     *
     * @return string
     */
    public function getContributeur()
    {
        return ($this->contributeur == 'true');
    }

    /**
     * Set contributeurMail
     *
     * @param string $contributeurMail
     *
     * @return Provider
     */
    public function setContributeurMail($contributeurMail)
    {
        $this->contributeurMail = $contributeurMail;

        return $this;
    }

    /**
     * Get contributeurMail
     *
     * @return string
     */
    public function getContributeurMail()
    {
        return $this->contributeurMail;
    }

    /**
     * Set validation_code
     *
     * @param string $validationCode
     *
     * @return Provider
     */
    public function setValidationCode($validationCode)
    {
        $this->validationCode = $validationCode;

        return $this;
    }

    /**
     * Get validation_code
     *
     * @return string
     */
    public function getValidationCode()
    {
        return $this->validationCode;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Provider
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set contactAmap
     *
     * @param string $contactAmap
     *
     * @return Provider
     */
    public function setContactAmap($contactAmap)
    {
        $this->contactAmap = $contactAmap;

        return $this;
    }

    /**
     * Get contactAmap
     *
     * @return string
     */
    public function getContactAmap()
    {
        return $this->contactAmap;
    }
    



    /**
     * Add product
     *
     * @param \Biopen\FournisseurBundle\Entity\ProviderProduct $product
     *
     * @return Provider
     */
    public function addProduct(\Biopen\FournisseurBundle\Entity\ProviderProduct $product)
    {
        $this->products[] = $product;
        $product->setProvider($this);
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Biopen\FournisseurBundle\Entity\ProviderProduct $product
     */
    public function removeProduct(\Biopen\FournisseurBundle\Entity\ProviderProduct $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Set latlng
     *
     * @param string $latlng
     *
     * @return Provider
     */
    public function setLatlng($latlng)
    {
        $this->latlng = $latlng;

        return $this;
    }

    /**
     * Get latlng
     *
     * @return string
     */
    public function getLatlng()
    {
        return $this->latlng;
    }

    /**
     * Set mainProduct
     *
     * @param string $mainProduct
     *
     * @return Provider
     */
    public function setMainProduct($mainProduct)
    {
        $this->mainProduct = $mainProduct;

        return $this;
    }

    /**
     * Get mainProduct
     *
     * @return string
     */
    public function getMainProduct()
    {
        return $this->mainProduct;
    }

  
}