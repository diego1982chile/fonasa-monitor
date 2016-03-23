<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema
 *
 * @ORM\Table(name="sistema")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\SistemaRepository")
 */
class Sistema
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=511, nullable=true)
     */
    private $descripcion;
    
    /**          
     * @ORM\OneToMany(targetEntity="Mantencion", mappedBy="sistema")          
     */
    protected $mantenciones;     
    
    /**          
     * @ORM\OneToMany(targetEntity="ModuloSistema", mappedBy="sistema")          
     */
    protected $modulos;       

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
     * @return Sistema
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }    

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Sistema
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Sistema
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
        
}

