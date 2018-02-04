<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CoreBundle\Entity\Pedidos
 *
 * @ORM\Entity()
 * @ORM\Table(name="pedidos", indexes={@ORM\Index(name="fk_pedidos_productos1_idx", columns={"idproductos"})})
 */
class Pedidos
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $telefono;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $cantidad;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $total;

    /**
     * @ORM\Column(name="`status`", type="boolean", nullable=true)
     */
    protected $status;

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
     * @ORM\ManyToOne(targetEntity="Productos", inversedBy="pedidos")
     * @ORM\JoinColumn(name="idproductos", referencedColumnName="id", nullable=false)
     */
    protected $productos;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Pedidos
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
     * Set the value of idproductos.
     *
     * @param integer $idproductos
     * @return \CoreBundle\Entity\Pedidos
     */
    public function setIdproductos($idproductos)
    {
        $this->idproductos = $idproductos;

        return $this;
    }

    /**
     * Get the value of idproductos.
     *
     * @return integer
     */
    public function getIdproductos()
    {
        return $this->idproductos;
    }

    /**
     * Set the value of nombre.
     *
     * @param string $nombre
     * @return \CoreBundle\Entity\Pedidos
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
     * Set the value of email.
     *
     * @param string $email
     * @return \CoreBundle\Entity\Pedidos
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
     * Set the value of telefono.
     *
     * @param string $telefono
     * @return \CoreBundle\Entity\Pedidos
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of telefono.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of cantidad.
     *
     * @param integer $cantidad
     * @return \CoreBundle\Entity\Pedidos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get the value of cantidad.
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of total.
     *
     * @param float $total
     * @return \CoreBundle\Entity\Pedidos
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of total.
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of status.
     *
     * @param boolean $status
     * @return \CoreBundle\Entity\Pedidos
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of status.
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Pedidos
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
     * @return \CoreBundle\Entity\Pedidos
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
     * Set Productos entity (many to one).
     *
     * @param \CoreBundle\Entity\Productos $productos
     * @return \CoreBundle\Entity\Pedidos
     */
    public function setProductos(Productos $productos = null)
    {
        $this->productos = $productos;

        return $this;
    }

    /**
     * Get Productos entity (many to one).
     *
     * @return \CoreBundle\Entity\Productos
     */
    public function getProductos()
    {
        return $this->productos;
    }

    public function __sleep()
    {
        return array('id', 'idproductos', 'nombre', 'email', 'telefono', 'cantidad', 'total', 'status', 'created_at', 'updated_at');
    }
}