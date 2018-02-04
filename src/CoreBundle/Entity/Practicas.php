<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CoreBundle\Entity\Practicas
 *
 * @ORM\Entity()
 * @ORM\Table(name="practicas", indexes={@ORM\Index(name="fk_practicas_cursos1_idx", columns={"idcursos"})})
 */
class Practicas
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
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $apaterno;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $amaterno;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $url;

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
     * @ORM\ManyToOne(targetEntity="Cursos", inversedBy="practicas")
     * @ORM\JoinColumn(name="idcursos", referencedColumnName="id", nullable=false)
     */
    protected $cursos;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Practicas
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
     * Set the value of idcursos.
     *
     * @param integer $idcursos
     * @return \CoreBundle\Entity\Practicas
     */
    public function setIdcursos($idcursos)
    {
        $this->idcursos = $idcursos;

        return $this;
    }

    /**
     * Get the value of idcursos.
     *
     * @return integer
     */
    public function getIdcursos()
    {
        return $this->idcursos;
    }

    /**
     * Set the value of nombre.
     *
     * @param string $nombre
     * @return \CoreBundle\Entity\Practicas
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
     * Set the value of apaterno.
     *
     * @param string $apaterno
     * @return \CoreBundle\Entity\Practicas
     */
    public function setApaterno($apaterno)
    {
        $this->apaterno = $apaterno;

        return $this;
    }

    /**
     * Get the value of apaterno.
     *
     * @return string
     */
    public function getApaterno()
    {
        return $this->apaterno;
    }

    /**
     * Set the value of amaterno.
     *
     * @param string $amaterno
     * @return \CoreBundle\Entity\Practicas
     */
    public function setAmaterno($amaterno)
    {
        $this->amaterno = $amaterno;

        return $this;
    }

    /**
     * Get the value of amaterno.
     *
     * @return string
     */
    public function getAmaterno()
    {
        return $this->amaterno;
    }

    /**
     * Set the value of email.
     *
     * @param string $email
     * @return \CoreBundle\Entity\Practicas
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of url.
     *
     * @param string $url
     * @return \CoreBundle\Entity\Practicas
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Practicas
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
     * @return \CoreBundle\Entity\Practicas
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
     * Set Cursos entity (many to one).
     *
     * @param \CoreBundle\Entity\Cursos $cursos
     * @return \CoreBundle\Entity\Practicas
     */
    public function setCursos(Cursos $cursos = null)
    {
        $this->cursos = $cursos;

        return $this;
    }

    /**
     * Get Cursos entity (many to one).
     *
     * @return \CoreBundle\Entity\Cursos
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    public function __sleep()
    {
        return array('id', 'idcursos', 'nombre', 'apaterno', 'amaterno', 'email', 'url', 'created_at', 'updated_at');
    }
}