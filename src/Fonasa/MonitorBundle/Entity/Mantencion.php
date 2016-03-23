<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mantencion
 *
 * @ORM\Table(name="mantencion")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\MantencionRepository")
 */
class Mantencion
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
     * @var string
     *
     * @ORM\Column(name="codigo_interno", type="string", length=255, unique=true)
     */
    private $codigoInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_externo", type="string", length=255, nullable=true, unique=true)
     */
    private $codigoExterno;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=1023)
     */
    private $descripcion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_reporte", type="datetime")
     */
    private $fechaReporte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime")
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_salida", type="datetime", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var int
     *
     * @ORM\Column(name="anyo", type="integer")
     */
    private $anyo;

    /**
     * @var int
     *
     * @ORM\Column(name="mes", type="integer")
     */
    private $mes;

    /**
     * @var int
     *
     * @ORM\Column(name="hh_estimadas", type="integer")
     */
    private $hhEstimadas;

    /**
     * @var int
     *
     * @ORM\Column(name="hh_efectivas", type="integer", nullable=true)
     */
    private $hhEfectivas;
    
    /**
     * @var \Sistema
     *
     * @ORM\ManyToOne(targetEntity="Sistema", inversedBy="mantenciones")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_SISTEMA", referencedColumnName="id")
     * })
     */
    protected $sistema;
    
    /**
     *      
     * @ORM\Column(name="ID_SISTEMA", type="integer", nullable=true)               
     */
    protected $idSistema;     
    
    
    /**
     * @var \Origen
     *
     * @ORM\ManyToOne(targetEntity="Origen", inversedBy="mantenciones")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_ORIGEN", referencedColumnName="id")
     * })
     */
    protected $origen;
    
    /**
     *      
     * @ORM\Column(name="ID_ORIGEN", type="integer", nullable=true)               
     */
    protected $idOrigen;                      
    
    /**
     * @var \Estado
     *
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="mantenciones")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_ESTADO", referencedColumnName="id")
     * })
     */
    protected $estado;
    
    /**
     *      
     * @ORM\Column(name="ID_ESTADO", type="integer", nullable=true)               
     */
    protected $idEstado;       

    /**
     * @var \Prioridad
     *
     * @ORM\ManyToOne(targetEntity="Prioridad", inversedBy="mantenciones")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_PRIORIDAD", referencedColumnName="id")
     * })
     */
    protected $prioridad;
    
    /**
     *      
     * @ORM\Column(name="ID_PRIORIDAD", type="integer", nullable=true)               
     */
    protected $idPrioridad;  
    
    /**
     * @var \Servicio
     *
     * @ORM\ManyToOne(targetEntity="Servicio", inversedBy="mantenciones")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_SERVICIO", referencedColumnName="id")
     * })
     */
    protected $servicio;
    
    /**
     *      
     * @ORM\Column(name="ID_SERVICIO", type="integer", nullable=true)               
     */
    protected $idServicio;      
    
    
    /**
     * @var \Impacto
     *
     * @ORM\ManyToOne(targetEntity="Impacto", inversedBy="mantenciones")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_IMPACTO", referencedColumnName="id")
     * })
     */
    protected $impacto;
    
    /**
     *      
     * @ORM\Column(name="ID_IMPACTO", type="integer", nullable=true)               
     */
    protected $idImpacto;          
    
    
    /**          
     * @ORM\OneToMany(targetEntity="Historial", mappedBy="mantencion")          
     */
    protected $historiales;    
    
    /**          
     * @ORM\OneToMany(targetEntity="Hh", mappedBy="mantencion")          
     */
    protected $hhs;        

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
     * Set codigoInterno
     *
     * @param string $codigoInterno
     *
     * @return Mantencion
     */
    public function setCodigoInterno($codigoInterno)
    {
        $this->codigoInterno = $codigoInterno;

        return $this;
    }

    /**
     * Get codigoInterno
     *
     * @return string
     */
    public function getCodigoInterno()
    {
        return $this->codigoInterno;
    }

    /**
     * Set codigoExterno
     *
     * @param string $codigoExterno
     *
     * @return Mantencion
     */
    public function setCodigoExterno($codigoExterno)
    {
        $this->codigoExterno = $codigoExterno;

        return $this;
    }

    /**
     * Get codigoExterno
     *
     * @return string
     */
    public function getCodigoExterno()
    {
        return $this->codigoExterno;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Mantencion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }    

    /**
     * Get fechaIngreso
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }
    
/**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     *
     * @return Mantencion
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }    
    
    /**
     * Get fechaReporte
     *
     * @return \DateTime
     */
    public function getFechaReporte()
    {
        return $this->fechaReporte;
    }    
    
    /**
     * Set fechaReporte
     *
     * @param \DateTime $fechaReporte
     *
     * @return Mantencion
     */
    public function setFechaReporte($fechaReporte)
    {
        $this->fechaReporte = $fechaReporte;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }     

    /**
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     *
     * @return Mantencion
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }    

    /**
     * Set anyo
     *
     * @param integer $anyo
     *
     * @return Mantencion
     */
    public function setAnyo($anyo)
    {
        $this->anyo = $anyo;

        return $this;
    }

    /**
     * Get anyo
     *
     * @return int
     */
    public function getAnyo()
    {
        return $this->anyo;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return Mantencion
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return int
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set hhEstimadas
     *
     * @param integer $hhEstimadas
     *
     * @return Mantencion
     */
    public function setHhEstimadas($hhEstimadas)
    {
        $this->hhEstimadas = $hhEstimadas;

        return $this;
    }

    /**
     * Get hhEstimadas
     *
     * @return int
     */
    public function getHhEstimadas()
    {
        return $this->hhEstimadas;
    }

    /**
     * Set hhEfectivas
     *
     * @param integer $hhEfectivas
     *
     * @return Mantencion
     */
    public function setHhEfectivas($hhEfectivas)
    {
        $this->hhEfectivas = $hhEfectivas;

        return $this;
    }

    /**
     * Get hhEfectivas
     *
     * @return int
     */
    public function getHhEfectivas()
    {
        return $this->hhEfectivas;
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
     * Set sistema
     *
     * @return \Fonasa\MonitorBundle\Entity\Mantencion
     */
    public function setSistema(\Fonasa\MonitorBundle\Entity\Sistema $sistema)
    {
        $this->sistema=$sistema;
        
        return $this;
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
    * @return Mantencion
    */
    public function setIdSistema($idSistema)
    {
        $this->idSistema = $idSistema;
        
        return $this;
    } 
    
    /**
     * Get origen
     *
     * @return \Fonasa\MonitorBundle\Entity\Origen
     */
    public function getOrigen()
    {
        return $this->origen;
    }
    
    /**
     * Set origen
     *
     * @return \Fonasa\MonitorBundle\Entity\Mantencion
     */
    public function setOrigen(\Fonasa\MonitorBundle\Entity\Origen $origen)
    {
        $this->origen=$origen;
        
        return $this;
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
    * Set idOrigen
    *
    * @param int $idOrigen
    * @return Mantencion
    */
    public function setIdOrigen($idOrigen)
    {
        $this->idOrigen = $idOrigen;
        
        return $this;
    }          
    
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
     * @return \Fonasa\MonitorBundle\Entity\Mantencion
     */
    public function setEstado(\Fonasa\MonitorBundle\Entity\Estado $estado)
    {
        $this->estado=$estado;
        
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
    * @return Mantencion
    */
    public function setIdEstado($idEstado)
    {
        $this->idEstado = $idEstado;
        
        return $this;
    }  

    /**
     * Get prioridad
     *
     * @return \Fonasa\MonitorBundle\Entity\Prioridad
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }
    
    /**
     * Set prioridad
     *
     * @return \Fonasa\MonitorBundle\Entity\Mantencion
     */
    public function setPrioridad(\Fonasa\MonitorBundle\Entity\Prioridad $prioridad)
    {
        $this->prioridad=$prioridad;
        
        return $this;
    }    
    
    /**
     * Get idEstado
     *
     * @return int
     */
    public function getIdPrioridad()
    {
        return $this->idPrioridad;
    }
    
    /**
    * Set idPrioridad
    *
    * @param int $idPrioridad
    * @return Mantencion
    */
    public function setIdPrioridad($idPrioridad)
    {
        $this->idPrioridad = $idPrioridad;
        
        return $this;
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
    * @return Mantencion
    */
    public function setIdServicio($idServicio)
    {
        $this->idServicio = $idServicio;
        
        return $this;
    }         
    
    /**
     * Get impacto
     *
     * @return \Fonasa\MonitorBundle\Entity\Impacto
     */
    public function getImpacto()
    {
        return $this->impacto;
    }
    
    /**
     * Get idImpacto
     *
     * @return int
     */
    public function getIdImpacto()
    {
        return $this->idImpacto;
    }
    
    /**
    * Set idImpacto
    *
    * @param int $idImpacto
    * @return Mantencion
    */
    public function setIdImpacto($idImpacto)
    {
        $this->idImpacto = $idImpacto;
        
        return $this;
    }             
    
}

