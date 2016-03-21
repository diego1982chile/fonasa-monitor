<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuloSistema
 *
 * @ORM\Table(name="modulo_sistema")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\ModuloSistemaRepository")
 */
class ModuloSistema
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
     * @var \Sistema
     *
     * @ORM\ManyToOne(targetEntity="Sistema", inversedBy="modulos")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_SISTEMA", referencedColumnName="id")
     * })
     */
    protected $sistema;
    
    /**
     *      
     * @ORM\Column(name="ID_SISTEMA", type="integer", nullable=true)               
     */
    private $idSistema;     
    
    /**
     * @var \Modulo
     *
     * @ORM\ManyToOne(targetEntity="Modulo", inversedBy="modulos")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_MODULO", referencedColumnName="id")
     * })
     */
    protected $modulo;
    
    /**
     *      
     * @ORM\Column(name="ID_MODULO", type="integer", nullable=true)               
     */
    private $idModulo;        

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
     * Get sistema
     *
     * @return \Fonasa\MonitorBundle\Entity\Sistema
     */
    public function getSistema()
    {
        return $this->sistema;
    }
    
    /**
     * Get idSistema
     *
     * @return int
     */
    public function getIdSistema()
    {
        return $this->idSistema;
    }
    
    /**
    * Set idSistema
    *
    * @param int $idSistema
    * @return ModuloSistema
    */
    public function setIdSistema($idSistema)
    {
        $this->idSistema = $idSistema;
        
        return $this;
    }     
    
    /**
     * Get modulo
     *
     * @return \Fonasa\MonitorBundle\Entity\Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }
    
    /**
     * Get idModulo
     *
     * @return int
     */
    public function getIdModulo()
    {
        return $this->idModulo;
    }
    
    /**
    * Set idModulo
    *
    * @param int $idModulo
    * @return ModuloSistema
    */
    public function setIdModulo($idModulo)
    {
        $this->idModulo = $idModulo;
        
        return $this;
    }        
}

