<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CoreBundle\Entity\Mensajes
 *
 * @ORM\Entity()
 * @ORM\Table(name="mensajes", indexes={@ORM\Index(name="fk_mensajes_usuarios1_idx", columns={"origen"}), @ORM\Index(name="fk_mensajes_usuarios2_idx", columns={"destino"})})
 */
class Mensajes
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $mensaje;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $leido;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios", inversedBy="mensajesRelatedByOrigens")
     * @ORM\JoinColumn(name="origen", referencedColumnName="id", nullable=false)
     */
    protected $usuariosRelatedByOrigen;

    /**
     * @ORM\ManyToOne(targetEntity="Usuarios", inversedBy="mensajesRelatedByDestinos")
     * @ORM\JoinColumn(name="destino", referencedColumnName="id", nullable=false)
     */
    protected $usuariosRelatedByDestino;

    public function __construct()
    {
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Mensajes
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
     * Set the value of origen.
     *
     * @param integer $origen
     * @return \CoreBundle\Entity\Mensajes
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get the value of origen.
     *
     * @return integer
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set the value of destino.
     *
     * @param integer $destino
     * @return \CoreBundle\Entity\Mensajes
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get the value of destino.
     *
     * @return integer
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set the value of mensaje.
     *
     * @param string $mensaje
     * @return \CoreBundle\Entity\Mensajes
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get the value of mensaje.
     *
     * @return string
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Mensajes
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
     * @return \CoreBundle\Entity\Mensajes
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
     * Set the value of leido.
     *
     * @param boolean $leido
     * @return \CoreBundle\Entity\Mensajes
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get the value of leido.
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set Usuarios entity related by `origen` (many to one).
     *
     * @param \CoreBundle\Entity\Usuarios $usuarios
     * @return \CoreBundle\Entity\Mensajes
     */
    public function setUsuariosRelatedByOrigen(Usuarios $usuarios = null)
    {
        $this->usuariosRelatedByOrigen = $usuarios;

        return $this;
    }

    /**
     * Get Usuarios entity related by `origen` (many to one).
     *
     * @return \CoreBundle\Entity\Usuarios
     */
    public function getUsuariosRelatedByOrigen()
    {
        return $this->usuariosRelatedByOrigen;
    }

    /**
     * Set Usuarios entity related by `destino` (many to one).
     *
     * @param \CoreBundle\Entity\Usuarios $usuarios
     * @return \CoreBundle\Entity\Mensajes
     */
    public function setUsuariosRelatedByDestino(Usuarios $usuarios = null)
    {
        $this->usuariosRelatedByDestino = $usuarios;

        return $this;
    }

    /**
     * Get Usuarios entity related by `destino` (many to one).
     *
     * @return \CoreBundle\Entity\Usuarios
     */
    public function getUsuariosRelatedByDestino()
    {
        return $this->usuariosRelatedByDestino;
    }

    public function __sleep()
    {
        return array('id', 'origen', 'destino', 'mensaje', 'created_at', 'updated_at', 'leido');
    }
}