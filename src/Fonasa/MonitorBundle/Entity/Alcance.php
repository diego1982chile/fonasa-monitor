<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alcance
 *
 * @ORM\Table(name="alcance")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\AlcanceRepository")
 */
class Alcance
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
     * @var \Componente
     *
     * @ORM\ManyToOne(targetEntity="Componente", inversedBy="alcances")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_COMPONENTE", referencedColumnName="id")
     * })
     */
    protected $componente;
    
    /**
     *      
     * @ORM\Column(name="ID_COMPONENTE", type="integer", nullable=true)               
     */
    private $idComponente;     
    
    /**
     * @var \TipoAlcance
     *
     * @ORM\ManyToOne(targetEntity="TipoAlcance", inversedBy="alcances")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_TIPOALCANCE", referencedColumnName="id")
     * })
     */
    protected $tipoAlcance;
    
    /**
     *      
     * @ORM\Column(name="ID_TIPOALCANCE", type="integer", nullable=true)               
     */
    private $idTipoAlcance;   
    
    /**          
     * @ORM\OneToMany(targetEntity="Servicio", mappedBy="alcance")          
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
     * @return Alcance
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }        
    
    /**
     * Get componente
     *
     * @return \Fonasa\MonitorBundle\Entity\Componente
     */
    public function getComponente()
    {
        return $this->componente;
    }
    
    /**
    * Set componente
    *
    * @param \Fonasa\MonitorBundle\Entity\Componente
    * @return Alcance
    */
    public function setComponente($componente)
    {
        $this->componente = $componente;
        
        return $this;
    }      
    
    /**
     * Get idComponente
     *
     * @return int
     */
    public function getIdComponente()
    {
        return $this->idComponente;
    }
    
    /**
    * Set idComponente
    *
    * @param int $idComponente
    * @return Alcance
    */
    public function setIdComponente($idComponente)
    {
        $this->idComponente = $idComponente;
        
        return $this;
    }     
    
    /**
     * Get tipoAlcance
     *
     * @return \Fonasa\MonitorBundle\Entity\TipoAlcance
     */
    public function getTipoAlcance()
    {
        return $this->tipoAlcance;
    }
    
    /**
    * Set tipoAlcance
    *
    * @param \Fonasa\MonitorBundle\Entity\TipoAlcance
    * @return Alcance
    */
    public function setTipoAlcance($tipoAlcance)
    {
        $this->tipoAlcance = $tipoAlcance;
        
        return $this;
    }          
    
    /**
     * Get idTipoAlcance
     *
     * @return int
     */
    public function getIdTipoAlcance()
    {
        return $this->idTipoAlcance;
    }
    
    /**
    * Set idTipoAlcance
    *
    * @param int $idTipoAlcance
    * @return Alcance
    */
    public function setIdTipoAlcance($idTipoAlcance)
    {
        $this->idTipoAlcance = $idTipoAlcance;
        
        return $this;
    }        
}

