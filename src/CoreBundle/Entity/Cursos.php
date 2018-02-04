<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CoreBundle\Entity\Cursos
 *
 * @ORM\Entity()
 * @ORM\Table(name="cursos", indexes={@ORM\Index(name="fk_cursos_usuarios_idx", columns={"idusuarios"}), @ORM\Index(name="fk_cursos_grupos1_idx", columns={"idgrupos"})})
 */
class Cursos
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fecha;

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
     * @ORM\OneToMany(targetEntity="Practicas", mappedBy="cursos")
     * @ORM\JoinColumn(name="id", referencedColumnName="idcursos", nullable=false)
     */
    protected $practicas;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios", inversedBy="cursos")
     * @ORM\JoinColumn(name="idusuarios", referencedColumnName="id", nullable=false)
     */
    protected $usuarios;

    /**
     * @ORM\ManyToOne(targetEntity="Grupos", inversedBy="cursos")
     * @ORM\JoinColumn(name="idgrupos", referencedColumnName="id", nullable=false)
     */
    protected $grupos;

    public function __construct()
    {
        $this->practicas = new ArrayCollection();
    }

    public function __toString() {
        return $this->grupos."-".$this->fecha->format('Y-m-d');;
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Cursos
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
     * Set the value of idusuarios.
     *
     * @param integer $idusuarios
     * @return \CoreBundle\Entity\Cursos
     */
    public function setIdusuarios($idusuarios)
    {
        $this->idusuarios = $idusuarios;

        return $this;
    }

    /**
     * Get the value of idusuarios.
     *
     * @return integer
     */
    public function getIdusuarios()
    {
        return $this->idusuarios;
    }

    /**
     * Set the value of idgrupos.
     *
     * @param integer $idgrupos
     * @return \CoreBundle\Entity\Cursos
     */
    public function setIdgrupos($idgrupos)
    {
        $this->idgrupos = $idgrupos;

        return $this;
    }

    /**
     * Get the value of idgrupos.
     *
     * @return integer
     */
    public function getIdgrupos()
    {
        return $this->idgrupos;
    }

    /**
     * Set the value of fecha.
     *
     * @param \DateTime $fecha
     * @return \CoreBundle\Entity\Cursos
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of fecha.
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of activo.
     *
     * @param boolean $activo
     * @return \CoreBundle\Entity\Cursos
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
     * @return \CoreBundle\Entity\Cursos
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
     * @return \CoreBundle\Entity\Cursos
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
     * Add Practicas entity to collection (one to many).
     *
     * @param \CoreBundle\Entity\Practicas $practicas
     * @return \CoreBundle\Entity\Cursos
     */
    public function addPracticas(Practicas $practicas)
    {
        $this->practicas[] = $practicas;

        return $this;
    }

    /**
     * Remove Practicas entity from collection (one to many).
     *
     * @param \CoreBundle\Entity\Practicas $practicas
     * @return \CoreBundle\Entity\Cursos
     */
    public function removePracticas(Practicas $practicas)
    {
        $this->practicas->removeElement($practicas);

        return $this;
    }

    /**
     * Get Practicas entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPracticas()
    {
        return $this->practicas;
    }

    /**
     * Set Usuarios entity (many to one).
     *
     * @param \CoreBundle\Entity\Usuarios $usuarios
     * @return \CoreBundle\Entity\Cursos
     */
    public function setUsuarios(Usuarios $usuarios = null)
    {
        $this->usuarios = $usuarios;

        return $this;
    }

    /**
     * Get Usuarios entity (many to one).
     *
     * @return \CoreBundle\Entity\Usuarios
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * Set Grupos entity (many to one).
     *
     * @param \CoreBundle\Entity\Grupos $grupos
     * @return \CoreBundle\Entity\Cursos
     */
    public function setGrupos(Grupos $grupos = null)
    {
        $this->grupos = $grupos;

        return $this;
    }

    /**
     * Get Grupos entity (many to one).
     *
     * @return \CoreBundle\Entity\Grupos
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    public function __sleep()
    {
        return array('id', 'idusuarios', 'idgrupos', 'fecha', 'activo', 'created_at', 'updated_at');
    }
}