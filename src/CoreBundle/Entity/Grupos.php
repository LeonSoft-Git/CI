<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CoreBundle\Entity\Grupos
 *
 * @ORM\Entity()
 * @ORM\Table(name="grupos", indexes={@ORM\Index(name="fk_grupos_empresas1_idx", columns={"idempresas"})})
 */
class Grupos
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $activo;

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
     * @ORM\OneToMany(targetEntity="Cursos", mappedBy="grupos")
     * @ORM\JoinColumn(name="id", referencedColumnName="idgrupos", nullable=false)
     */
    protected $cursos;

    /**
     * @ORM\ManyToOne(targetEntity="Empresas", inversedBy="grupos")
     * @ORM\JoinColumn(name="idempresas", referencedColumnName="id", nullable=false)
     */
    protected $empresas;

    public function __construct()
    {
        $this->cursos = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Grupos
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
     * Set the value of idempresas.
     *
     * @param integer $idempresas
     * @return \CoreBundle\Entity\Grupos
     */
    public function setIdempresas($idempresas)
    {
        $this->idempresas = $idempresas;

        return $this;
    }

    /**
     * Get the value of idempresas.
     *
     * @return integer
     */
    public function getIdempresas()
    {
        return $this->idempresas;
    }

    /**
     * Set the value of nombre.
     *
     * @param string $nombre
     * @return \CoreBundle\Entity\Grupos
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
     * Set the value of activo.
     *
     * @param boolean $activo
     * @return \CoreBundle\Entity\Grupos
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get the value of activo.
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Grupos
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
     * @return \CoreBundle\Entity\Grupos
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

    /**
     * Add Cursos entity to collection (one to many).
     *
     * @param \CoreBundle\Entity\Cursos $cursos
     * @return \CoreBundle\Entity\Grupos
     */
    public function addCursos(Cursos $cursos)
    {
        $this->cursos[] = $cursos;

        return $this;
    }

    /**
     * Remove Cursos entity from collection (one to many).
     *
     * @param \CoreBundle\Entity\Cursos $cursos
     * @return \CoreBundle\Entity\Grupos
     */
    public function removeCursos(Cursos $cursos)
    {
        $this->cursos->removeElement($cursos);

        return $this;
    }

    /**
     * Get Cursos entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    /**
     * Set Empresas entity (many to one).
     *
     * @param \CoreBundle\Entity\Empresas $empresas
     * @return \CoreBundle\Entity\Grupos
     */
    public function setEmpresas(Empresas $empresas = null)
    {
        $this->empresas = $empresas;

        return $this;
    }

    /**
     * Get Empresas entity (many to one).
     *
     * @return \CoreBundle\Entity\Empresas
     */
    public function getEmpresas()
    {
        return $this->empresas;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function __sleep()
    {
        return array('id', 'idempresas', 'nombre', 'activo', 'created_at', 'updated_at');
    }
}