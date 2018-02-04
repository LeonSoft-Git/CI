<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CoreBundle\Entity\Productos
 *
 * @ORM\Entity()
 * @ORM\Table(name="productos", indexes={@ORM\Index(name="fk_productos_categorias1_idx", columns={"idcategorias"})})
 */
class Productos
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $sku;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $imagen;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    protected $precio;

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
     * @ORM\OneToMany(targetEntity="Pedidos", mappedBy="productos")
     * @ORM\JoinColumn(name="id", referencedColumnName="idproductos", nullable=false)
     */
    protected $pedidos;

    /**
     * @ORM\ManyToOne(targetEntity="Categorias", inversedBy="productos")
     * @ORM\JoinColumn(name="idcategorias", referencedColumnName="id", nullable=false)
     */
    protected $categorias;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Productos
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
     * Set the value of idcategorias.
     *
     * @param integer $idcategorias
     * @return \CoreBundle\Entity\Productos
     */
    public function setIdcategorias($idcategorias)
    {
        $this->idcategorias = $idcategorias;

        return $this;
    }

    /**
     * Get the value of idcategorias.
     *
     * @return integer
     */
    public function getIdcategorias()
    {
        return $this->idcategorias;
    }

    /**
     * Set the value of sku.
     *
     * @param string $sku
     * @return \CoreBundle\Entity\Productos
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get the value of sku.
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set the value of nombre.
     *
     * @param string $nombre
     * @return \CoreBundle\Entity\Productos
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
     * Set the value of imagen.
     *
     * @param string $imagen
     * @return \CoreBundle\Entity\Productos
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get the value of imagen.
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of descripcion.
     *
     * @param string $descripcion
     * @return \CoreBundle\Entity\Productos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of precio.
     *
     * @param float $precio
     * @return \CoreBundle\Entity\Productos
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of precio.
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of activo.
     *
     * @param boolean $activo
     * @return \CoreBundle\Entity\Productos
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
     * @return \CoreBundle\Entity\Productos
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
     * @return \CoreBundle\Entity\Productos
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
     * Add Pedidos entity to collection (one to many).
     *
     * @param \CoreBundle\Entity\Pedidos $pedidos
     * @return \CoreBundle\Entity\Productos
     */
    public function addPedidos(Pedidos $pedidos)
    {
        $this->pedidos[] = $pedidos;

        return $this;
    }

    /**
     * Remove Pedidos entity from collection (one to many).
     *
     * @param \CoreBundle\Entity\Pedidos $pedidos
     * @return \CoreBundle\Entity\Productos
     */
    public function removePedidos(Pedidos $pedidos)
    {
        $this->pedidos->removeElement($pedidos);

        return $this;
    }

    /**
     * Get Pedidos entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Set Categorias entity (many to one).
     *
     * @param \CoreBundle\Entity\Categorias $categorias
     * @return \CoreBundle\Entity\Productos
     */
    public function setCategorias(Categorias $categorias = null)
    {
        $this->categorias = $categorias;

        return $this;
    }

    /**
     * Get Categorias entity (many to one).
     *
     * @return \CoreBundle\Entity\Categorias
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    public function __sleep()
    {
        return array('id', 'idcategorias', 'sku', 'nombre', 'imagen', 'descripcion', 'precio', 'activo', 'created_at', 'updated_at');
    }
}