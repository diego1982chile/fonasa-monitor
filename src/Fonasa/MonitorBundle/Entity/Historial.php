<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historial
 *
 * @ORM\Table(name="historial")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\HistorialRepository")
 */
class Historial
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
     * @ORM\Column(name="inicio", type="datetime")
     */
    private $inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="termino", type="datetime", nullable=true)
     */
    private $termino;
    
    /**
     * @var \Servicio
     *
     * @ORM\ManyToOne(targetEntity="Servicio", inversedBy="historiales")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_SERVICIO", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $servicio;
    
    /**
     *      
     * @ORM\Column(name="ID_SERVICIO", type="integer", nullable=true)               
     */
    private $idServicio;      
    
    
    /**
     * @var \Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="historiales")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_ESTADO", referencedColumnName="id")
     * })
     */
    protected $estado;
    
    /**
     *      
     * @ORM\Column(name="ID_ESTADO", type="integer", nullable=true)               
     */
    private $idEstado;      


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
     * Set inicio
     *
     * @param \DateTime $inicio
     *
     * @return Historial
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set termino
     *
     * @param \DateTime $termino
     *
     * @return Historial
     */
    public function setTermino($termino)
    {
        $this->termino = $termino;

        return $this;
    }

    /**
     * Get termino
     *
     * @return \DateTime
     */
    public function getTermino()
    {
        return $this->termino;
    }
    
    /**
     * Get servicio
     *
     * @return \Fonasa\MonitorBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }
    
    /**
     * Set servicio
     *
     * @return \Fonasa\MonitorBundle\Entity\Historial      
     */
    public function setServicio(\Fonasa\MonitorBundle\Entity\Servicio $servicio = null)
    {
        $this->servicio = $servicio;
        
        return $this;
    }            
    
    /**
     * Get idServicio
     *
     * @return int
     */
    public function getIdServicio()
    {
        return $this->idServicio;
    }
    
    /**
    * Set idServicio
    *
    * @param int $idServicio
    * @return Historial
    */
    public function setIdServicio($idServicio)
    {
        $this->idServicio = $idServicio;
        
        return $this;
    }      
    
    //-----------------------------------------------------------
    
    /**
     * Get estado
     *
     * @return \Fonasa\MonitorBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    /**
     * Set estado
     *
     * @return \Fonasa\MonitorBundle\Entity\Historial
     */
    public function setEstado(\Fonasa\MonitorBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;
        
        return $this;
    }            
    
    /**
     * Get idEstado
     *
     * @return int
     */
    public function getIdEstado()
    {
        return $this->idEstado;
    }
    
    /**
    * Set idEstado
    *
    * @param int $idEstado
    * @return Historial
    */
    public function setIdEstado($idEstado)
    {
        $this->idEstado = $idEstado;
        
        return $this;
    }  
}

