<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hh
 *
 * @ORM\Table(name="hh")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\HhRepository")
 */
class Hh
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
     * @var \DateTime
     *
     * @ORM\Column(name="dia", type="date")
     */
    private $dia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time")
     */
    private $hora;

    /**
     * @var \Mantencion
     *
     * @ORM\ManyToOne(targetEntity="Mantencion", inversedBy="hhs")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_MANTENCION", referencedColumnName="id")
     * })
     */
    protected $mantencion;
    
    /**
     *      
     * @ORM\Column(name="ID_MANTENCION", type="integer", nullable=true)               
     */
    private $idMantencion;  
    
    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="hhs")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_USUARIO", referencedColumnName="id")
     * })
     */
    protected $usuario;
    
    /**
     *      
     * @ORM\Column(name="ID_USUARIO", type="integer", nullable=true)               
     */
    private $idUsuario; 
    
    
    /**
     * @var \TareaUsuario
     *
     * @ORM\ManyToOne(targetEntity="TareaUsuario", inversedBy="hhs")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_TAREAUSUARIO", referencedColumnName="id")
     * })
     */
    protected $tareaUsuario;
    
    /**
     *      
     * @ORM\Column(name="ID_TAREAUSUARIO", type="integer", nullable=true)               
     */
    private $idTareaUsuario;        

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
     * Set dia
     *
     * @param \DateTime $dia
     *
     * @return Hh
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return \DateTime
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return Hh
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }
    
    /**
     * Get mantencion
     *
     * @return \Fonasa\MonitorBundle\Entity\Mantencion
     */
    public function getMantencion()
    {
        return $this->mantencion;
    }
    
    /**
     * Get idMantencion
     *
     * @return int
     */
    public function getIdMantencion()
    {
        return $this->idMantencion;
    }
    
    /**
    * Set idMantencion
    *
    * @param int $idMantencion
    * @return Hh
    */
    public function setIdMantencion($idMantencion)
    {
        $this->idMantencion = $idMantencion;
        
        return $this;
    }      
    
    /**
     * Get usuario
     *
     * @return \Fonasa\MonitorBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    /**
     * Get idUsuario
     *
     * @return int
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
    
    /**
    * Set idUsuario
    *
    * @param int $idUsuario
    * @return Hh
    */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
        
        return $this;
    } 
    
    /**
     * Get tareaUsuario
     *
     * @return \Fonasa\MonitorBundle\Entity\TareaUsuario
     */
    public function getTareaUsuario()
    {
        return $this->tareaUsuario;
    }
    
    /**
     * Get idTareaUsuario
     *
     * @return int
     */
    public function getIdTareaUsuario()
    {
        return $this->idTareaUsuario;
    }
    
    /**
    * Set idTareaUsuario
    *
    * @param int $idTareaUsuario
    * @return Hh
    */
    public function setIdTareaUsuario($idTareaUsuario)
    {
        $this->idTareaUsuario = $idTareaUsuario;
        
        return $this;
    }     
}

