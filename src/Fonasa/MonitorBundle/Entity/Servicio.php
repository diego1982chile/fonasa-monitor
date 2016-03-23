<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servicio
 *
 * @ORM\Table(name="servicio")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\ServicioRepository")
 */
class Servicio
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
     * @ORM\ManyToOne(targetEntity="Tipo", inversedBy="servicios")
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
     * @ORM\ManyToOne(targetEntity="Origen", inversedBy="servicios")
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
     * @ORM\OneToMany(targetEntity="Mantencion", mappedBy="servicio")          
     */
    protected $mantenciones;        
    
    
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
     * @return Servicio
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
    * @return Servicio
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
    * @return Mantencion
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
    * @return Servicio
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
    * @return Servicio
    */
    public function setIdOrigen($idOrigen)
    {
        $this->idOrigen = $idOrigen;
        
        return $this;
    }         
}

