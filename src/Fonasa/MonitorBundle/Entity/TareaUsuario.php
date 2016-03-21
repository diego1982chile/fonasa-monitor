<?php

namespace Fonasa\MonitorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TareaUsuario
 *
 * @ORM\Table(name="tarea_usuario")
 * @ORM\Entity(repositoryClass="Fonasa\MonitorBundle\Repository\TareaUsuarioRepository")
 */
class TareaUsuario
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
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="tareasUsuario")
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
     * @var \Tarea
     *
     * @ORM\ManyToOne(targetEntity="Tarea", inversedBy="tareas")
     * @ORM\JoinColumns{(
     *    @ORM\JoinColumn(name="ID_TAREA", referencedColumnName="id")
     * })
     */
    protected $tarea;    

    /**
     *      
     * @ORM\Column(name="ID_TAREA", type="integer", nullable=true)               
     */
    private $idTarea;       
    
    /**          
     * @ORM\OneToMany(targetEntity="TareaUsuario", mappedBy="tareaUsuario")          
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
    * @return TareaUsuario
    */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
        
        return $this;
    }
    
    /**
     * Get tarea
     *
     * @return \Fonasa\MonitorBundle\Entity\Tarea
     */
    public function getTarea()
    {
        return $this->tarea;
    }
    
    /**
     * Get idTarea
     *
     * @return int
     */
    public function getIdTarea()
    {
        return $this->idTarea;
    }
    
    /**
    * Set idTarea
    *
    * @param int $idTarea
    * @return TareaUsuario
    */
    public function setIdTarea($idTarea)
    {
        $this->idTarea = $idTarea;
        
        return $this;
    }
}

