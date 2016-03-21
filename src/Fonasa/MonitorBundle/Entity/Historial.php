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
     * @var \Mantencion
     *
     * @ORM\ManyToOne(targetEntity="Mantencion", inversedBy="historiales")
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
    * @return Historial
    */
    public function setIdMantencion($idMantencion)
    {
        $this->idMantencion = $idMantencion;
        
        return $this;
    }      
}

