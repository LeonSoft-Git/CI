<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CoreBundle\Entity\Empresas
 *
 * @ORM\Entity()
 * @ORM\Table(name="empresas")
 */
class Empresas
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $direccion;

    /**
     * @Gedmo\Slug(separator="-", updatable=true, fields={"nombre"})
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $slug;

    /**
     * @Gedmo\Timestampable(on="create", field="creado")
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @Gedmo\Timestampable(on="update", field="actualizado")
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Archivos", mappedBy="empresas")
     * @ORM\JoinColumn(name="id", referencedColumnName="idempresas", nullable=false)
     */
    protected $archivos;

    /**
     * @ORM\OneToMany(targetEntity="Grupos", mappedBy="empresas")
     * @ORM\JoinColumn(name="id", referencedColumnName="idempresas", nullable=false)
     */
    protected $grupos;

    public function __construct()
    {
        $this->archivos = new ArrayCollection();
        $this->grupos = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Empresas
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of nombre.
     *
     * @param string $nombre
     * @return \CoreBundle\Entity\Empresas
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of direccion.
     *
     * @param string $direccion
     * @return \CoreBundle\Entity\Empresas
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of direccion.
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of slug.
     *
     * @param string $slug
     * @return \CoreBundle\Entity\Empresas
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Empresas
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of created_at.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of updated_at.
     *
     * @param \DateTime $updated_at
     * @return \CoreBundle\Entity\Empresas
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of updated_at.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function __toString() {
        return $this->nombre;
    }

    /**
     * Add Archivos entity to collection (one to many).
     *
     * @param \CoreBundle\Entity\Archivos $archivos
     * @return \CoreBundle\Entity\Empresas
     */
    public function addArchivos(Archivos $archivos)
    {
        $this->archivos[] = $archivos;

        return $this;
    }

    /**
     * Remove Archivos entity from collection (one to many).
     *
     * @param \CoreBundle\Entity\Archivos $archivos
     * @return \CoreBundle\Entity\Empresas
     */
    public function removeArchivos(Archivos $archivos)
    {
        $this->archivos->removeElement($archivos);

        return $this;
    }

    /**
     * Get Archivos entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivos()
    {
        return $this->archivos;
    }

    /**
     * Add Grupos entity to collection (one to many).
     *
     * @param \CoreBundle\Entity\Grupos $grupos
     * @return \CoreBundle\Entity\Empresas
     */
    public function addGrupos(Grupos $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove Grupos entity from collection (one to many).
     *
     * @param \CoreBundle\Entity\Grupos $grupos
     * @return \CoreBundle\Entity\Empresas
     */
    public function removeGrupos(Grupos $grupos)
    {
        $this->grupos->removeElement($grupos);

        return $this;
    }

    /**
     * Get Grupos entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    public function __sleep()
    {
        return array('id', 'nombre', 'direccion', 'slug', 'created_at', 'updated_at');
    }
}