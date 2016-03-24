<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoServicio
 *
 * @ORM\Table(name="tipo_servicio")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\TipoServicioRepository")
 */
class TipoServicio
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
     * @var \Tipo
     *
     * @ORM\ManyToOne(targetEntity="Tipo", inversedBy="tiposServicio")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_TIPO", referencedColumnName="id")
     * })
     */
    protected $tipo;
    
    /**
     *      
     * @ORM\Column(name="ID_TIPO", type="integer", nullable=true)               
     */
    private $idTipo;   
        
    /**
     * @var \Origen
     *
     * @ORM\ManyToOne(targetEntity="Origen", inversedBy="tiposServicio")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_ORIGEN", referencedColumnName="id")
     * })
     */
    protected $origen;
    
    /**
     *      
     * @ORM\Column(name="ID_ORIGEN", type="integer", nullable=true)               
     */
    private $idOrigen;       
    
    /**          
     * @ORM\OneToMany(targetEntity="Servicio", mappedBy="tipoServicio")          
     */
    protected $servicios;        
    
    
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
     * Set id
     *
     * @param string $id
     *
     * @return TipoServicio
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }    
    
    /**
     * Get tipo
     *
     * @return \Fonasa\MonitorBundle\Entity\Tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * Get idTipo
     *
     * @return int
     */
    public function getIdTipo()
    {
        return $this->idTipo;
    }
    
    /**
    * Set tipo
    *
    * @param \Fonasa\MonitorBundle\Entity\Tipo
    * @return TipoServicio
    */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        
        return $this;
    }      
    
    /**
    * Set idTipo
    *
    * @param int $idTipo
    * @return TipoServicio
    */
    public function setIdTipo($idTipo)
    {
        $this->idTipo = $idTipo;
        
        return $this;
    }     
    
    /**
     * Get tipo
     *
     * @return \Fonasa\MonitorBundle\Entity\Origen
     */
    public function getOrigen()
    {
        return $this->origen;
    }
    
    /**
     * Get idOrigen
     *
     * @return int
     */
    public function getIdOrigen()
    {
        return $this->idOrigen;
    }
    
    /**
    * Set origen
    *
    * @param \Fonasa\MonitorBundle\Entity\Origen
    * @return TipoServicio
    */
    public function setOrigen($origen)
    {
        $this->origen = $origen;
        
        return $this;
    }        
    
    /**
    * Set idOrigen
    *
    * @param int $idOrigen
    * @return TipoServicio
    */
    public function setIdOrigen($idOrigen)
    {
        $this->idOrigen = $idOrigen;
        
        return $this;
    }         
}

