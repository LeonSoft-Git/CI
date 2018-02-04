<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * CoreBundle\Entity\Usuarios
 *
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\UsuariosRepository")
 * @ORM\Table(name="usuarios")
 */
class Usuarios implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="`password`", type="string", length=200, nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $activo;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $verificado;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $salt;

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
     * @ORM\OneToMany(targetEntity="Cursos", mappedBy="usuarios")
     * @ORM\JoinColumn(name="id", referencedColumnName="idusuarios", nullable=false)
     */
    protected $cursos;

    /**
     * @ORM\OneToMany(targetEntity="Mensajes", mappedBy="usuariosRelatedByOrigen")
     * @ORM\JoinColumn(name="id", referencedColumnName="origen", nullable=false)
     */
    protected $mensajesRelatedByOrigens;

    /**
     * @ORM\OneToMany(targetEntity="Mensajes", mappedBy="usuariosRelatedByDestino")
     * @ORM\JoinColumn(name="id", referencedColumnName="destino", nullable=false)
     */
    protected $mensajesRelatedByDestinos;

    public function __construct()
    {
        $this->cursos = new ArrayCollection();
        $this->mensajesRelatedByOrigens = new ArrayCollection();
        $this->mensajesRelatedByDestinos = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * Set the value of password.
     *
     * @param string $password
     * @return \CoreBundle\Entity\Usuarios
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
     * Set the value of tipo.
     *
     * @param boolean $tipo
     * @return \CoreBundle\Entity\Usuarios
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of tipo.
     *
     * @return boolean
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of activo.
     *
     * @param boolean $activo
     * @return \CoreBundle\Entity\Usuarios
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
     * Set the value of verificado.
     *
     * @param boolean $verificado
     * @return \CoreBundle\Entity\Usuarios
     */
    public function setVerificado($verificado)
    {
        $this->verificado = $verificado;

        return $this;
    }

    /**
     * Get the value of verificado.
     *
     * @return boolean
     */
    public function getVerificado()
    {
        return $this->verificado;
    }

    /**
     * Set the value of salt.
     *
     * @param string $salt
     * @return \CoreBundle\Entity\Usuarios
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get the value of salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set the value of created_at.
     *
     * @param \DateTime $created_at
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * @return \CoreBundle\Entity\Usuarios
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
     * Add Mensajes entity related by `origen` to collection (one to many).
     *
     * @param \CoreBundle\Entity\Mensajes $mensajes
     * @return \CoreBundle\Entity\Usuarios
     */
    public function addMensajesRelatedByOrigen(Mensajes $mensajes)
    {
        $this->mensajesRelatedByOrigens[] = $mensajes;

        return $this;
    }

    /**
     * Remove Mensajes entity related by `origen` from collection (one to many).
     *
     * @param \CoreBundle\Entity\Mensajes $mensajes
     * @return \CoreBundle\Entity\Usuarios
     */
    public function removeMensajesRelatedByOrigen(Mensajes $mensajes)
    {
        $this->mensajesRelatedByOrigens->removeElement($mensajes);

        return $this;
    }

    /**
     * Get Mensajes entity related by `origen` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMensajesRelatedByOrigens()
    {
        return $this->mensajesRelatedByOrigens;
    }

    /**
     * Add Mensajes entity related by `destino` to collection (one to many).
     *
     * @param \CoreBundle\Entity\Mensajes $mensajes
     * @return \CoreBundle\Entity\Usuarios
     */
    public function addMensajesRelatedByDestino(Mensajes $mensajes)
    {
        $this->mensajesRelatedByDestinos[] = $mensajes;

        return $this;
    }

    /**
     * Remove Mensajes entity related by `destino` from collection (one to many).
     *
     * @param \CoreBundle\Entity\Mensajes $mensajes
     * @return \CoreBundle\Entity\Usuarios
     */
    public function removeMensajesRelatedByDestino(Mensajes $mensajes)
    {
        $this->mensajesRelatedByDestinos->removeElement($mensajes);

        return $this;
    }

    /**
     * Get Mensajes entity related by `destino` collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMensajesRelatedByDestinos()
    {
        return $this->mensajesRelatedByDestinos;
    }

    public function __toString() {
        return $this->nombre." ".$this->apaterno;
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    public function __sleep()
    {
        return array('id', 'nombre', 'apaterno', 'amaterno', 'email', 'password', 'tipo', 'activo', 'verificado', 'salt', 'created_at', 'updated_at');
    }
}