<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CoreBundle\Entity\Archivos
 *
 * @ORM\Entity()
 * @ORM\Table(name="archivos", indexes={@ORM\Index(name="fk_archivos_empresas1_idx", columns={"idempresas"})})
 */
class Archivos
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
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(name="`password`", type="string", length=15, nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $activo;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $categoria;

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
     * @ORM\ManyToOne(targetEntity="Empresas", inversedBy="archivos")
     * @ORM\JoinColumn(name="idempresas", referencedColumnName="id", nullable=false)
     */
    protected $empresas;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Archivos
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
     * @return \CoreBundle\Entity\Archivos
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
     * @return \CoreBundle\Entity\Archivos
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
     * Set the value of url.
     *
     * @param string $url
     * @return \CoreBundle\Entity\Archivos
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
     * Set the value of password.
     *
     * @param string $password
     * @return \CoreBundle\Entity\Archivos
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of activo.
     *
     * @param boolean $activo
     * @return \CoreBundle\Entity\Archivos
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
     * Set the value of tipo.
     *
     * @param integer $tipo
     * @return \CoreBundle\Entity\Archivos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of tipo.
     *
     * @return integer
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of categoria.
     *
     * @param integer $categoria
     * @return \CoreBundle\Entity\Archivos
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get the value of categoria.
     *
     * @return integer
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Archivos
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
     * @return \CoreBundle\Entity\Archivos
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
     * Set Empresas entity (many to one).
     *
     * @param \CoreBundle\Entity\Empresas $empresas
     * @return \CoreBundle\Entity\Archivos
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

    public function __sleep()
    {
        return array('id', 'idempresas', 'nombre', 'url', 'password', 'activo', 'tipo', 'categoria', 'created_at', 'updated_at');
    }
}