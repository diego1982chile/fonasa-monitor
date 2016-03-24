<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoAlcance
 *
 * @ORM\Table(name="tipo_alcance")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\TipoAlcanceRepository")
 */
class TipoAlcance
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
     * @ORM\OneToMany(targetEntity="Alcance", mappedBy="tipoAlcance")          
     */
    protected $alcances;         


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
     * @return TipoAlcance
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
     * @return TipoAlcance
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
     * @return TipoAlcance
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

