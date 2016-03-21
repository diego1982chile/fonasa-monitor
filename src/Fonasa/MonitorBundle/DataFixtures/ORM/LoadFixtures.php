<?php
// src/AppBundle/DataFixtures/ORM/LoadUserData.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fonasa\MonitorBundle\Entity\Area;
use Fonasa\MonitorBundle\Entity\Estado;
use Fonasa\MonitorBundle\Entity\Origen;
use Fonasa\MonitorBundle\Entity\Prioridad;
use Fonasa\MonitorBundle\Entity\Sistema;
use Fonasa\MonitorBundle\Entity\Tarea;
use Fonasa\MonitorBundle\Entity\TareaUsuario;
use Fonasa\MonitorBundle\Entity\Tipo;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $area = new Area();
        $area->setNombre("Análisis");
        $area->setDescripcion("Área encargada de analizar y gestionar los requerimientos y/o incidencias, generando mantenciones asociadas");        

        $manager->persist($area);
        $manager->flush();
        
        $area = new Area();
        $area->setNombre("Desarrollo");
        $area->setDescripcion("Área encargada de desarrollar las mantenciones generadas por el área de análisis");        

        $manager->persist($area);
        $manager->flush();
        
        $area = new Area();
        $area->setNombre("Testing");
        $area->setDescripcion("Área encargada de testear las mantenciones generadas por el área de desarrollo");                        

        $manager->persist($area);
        $manager->flush();        
        
        $area = new Area();
        $area->setNombre("Explotación");
        $area->setDescripcion("Área encargada de certificar las mantenciones generadas por testing y realizar PaP");                
        
        $manager->persist($area);
        $manager->flush(); 
        
        $estado = new Estado();
        $estado->setNombre("En Cola");
        $estado->setDescripcion("Por asignar a desarrollo");                
        
        $manager->persist($estado);
        $manager->flush();   
        
        $estado = new Estado();
        $estado->setNombre("Desarrollo");
        $estado->setDescripcion("Asignada a desarrollo");                
        
        $manager->persist($estado);
        $manager->flush();               
        
        $estado = new Estado();
        $estado->setNombre("Testing");
        $estado->setDescripcion("En testing");                
        
        $manager->persist($estado);
        $manager->flush();                 
        
        $estado = new Estado();
        $estado->setNombre("Explotación");
        $estado->setDescripcion("En certificación");                
        
        $manager->persist($estado);
        $manager->flush();                       
        
        $estado = new Estado();
        $estado->setNombre("Pendiente PaP");
        $estado->setDescripcion("Pendiente aprobación PaP");                
        
        $manager->persist($estado);
        $manager->flush();           
        
        $estado = new Estado();
        $estado->setNombre("Terminada");
        $estado->setDescripcion("Terminada");                
        
        $manager->persist($estado);
        $manager->flush();       
        
        $origen = new Origen();
        $origen->setNombre("Requerimiento");
        $origen->setDescripcion("Requerimiento FONASA");                
        
        $manager->persist($origen);
        $manager->flush();         
        
        $origen = new Origen();
        $origen->setNombre("Mesa");
        $origen->setDescripcion("Mesa de ayuda");                
        
        $manager->persist($origen);
        $manager->flush();       
        
        $prioridad = new Prioridad();
        $prioridad->setNombre("Alta");
        $prioridad->setDescripcion("Prioridad alta");                
        
        $manager->persist($prioridad);
        $manager->flush();            
        
        $prioridad = new Prioridad();
        $prioridad->setNombre("Media");
        $prioridad->setDescripcion("Prioridad media");                
        
        $manager->persist($prioridad);
        $manager->flush();                  
        
        $prioridad = new Prioridad();
        $prioridad->setNombre("Baja");
        $prioridad->setDescripcion("Prioridad baja");                
        
        $manager->persist($prioridad);
        $manager->flush();                  
        
        $sistema = new Sistema();
        $sistema->setNombre("SIGGES");
        $sistema->setDescripcion("Sistema de monitoreo de Garantias de Oportunidad");                
        
        $manager->persist($sistema);
        $manager->flush();        
        
        $sistema = new Sistema();
        $sistema->setNombre("GGPF");
        $sistema->setDescripcion("Sistema de monitoreo de Garantias financieras");                
        
        $manager->persist($sistema);
        $manager->flush();                
        
        $tipo = new Tipo();
        $tipo->setNombre("Incidencia");
        $tipo->setDescripcion("Incidencia");                
        
        $manager->persist($tipo);
        $manager->flush();  
        
        $tipo = new Tipo();
        $tipo->setNombre("Mantención Correctiva");
        $tipo->setDescripcion("Mantención correctiva");                
        
        $manager->persist($tipo);
        $manager->flush();          
        
        $tipo = new Tipo();
        $tipo->setNombre("Mantención Evolutiva");
        $tipo->setDescripcion("Mantención evolutiva");                
        
        $manager->persist($tipo);
        $manager->flush();                  
        
        $tipo = new Tipo();
        $tipo->setNombre("Mantención Adaptativa");
        $tipo->setDescripcion("Mantención Adaptativa");                
        
        $manager->persist($tipo);
        $manager->flush();                   
        
        $servicio = new Servicio();
        $servicio->setIdOrigen(1);        
        $servicio->setIdTipo(1);        
        
        $manager->persist($servicio);
        $manager->flush();                           
        
        $servicio = new Servicio();
        $servicio->setIdOrigen(1);
        $servicio->setIdTipo(2);                
        
        $manager->persist($servicio);
        $manager->flush();                
        
        $servicio = new Servicio();
        $servicio->setIdOrigen(2);
        $servicio->setIdTipo(2);                
        
        $manager->persist($servicio);
        $manager->flush();      
        
        $servicio = new Servicio();
        $servicio->setIdOrigen(2);
        $servicio->setIdTipo(3);                
        
        $manager->persist($servicio);
        $manager->flush();            
        
        $tarea = new Tarea();
        $tarea->setNombre("Análisis y diseño");
        $tarea->setDescripcion("Análisis y diseño");                
        
        $manager->persist($tarea);
        $manager->flush();  
        
        $tarea = new Tarea();
        $tarea->setNombre("Preparación Scripts");
        $tarea->setDescripcion("Preparación Scripts");                
        
        $manager->persist($tarea);
        $manager->flush();          
        
        $tarea = new Tarea();
        $tarea->setNombre("Preparación Documentación");
        $tarea->setDescripcion("Preparación Documentación");                
        
        $manager->persist($tarea);
        $manager->flush();          
        
        $tarea = new Tarea();
        $tarea->setNombre("Generación WAR y CD");
        $tarea->setDescripcion("Generación WAR y CD");                
        
        $manager->persist($tarea);
        $manager->flush();  
        
        $tarea = new Tarea();
        $tarea->setNombre("Revisión documentación");
        $tarea->setDescripcion("Revisión documentación");                
        
        $manager->persist($tarea);
        $manager->flush();             
        
        $tarea = new Tarea();
        $tarea->setNombre("Revisión Scripts");
        $tarea->setDescripcion("Revisión Scripts");                
        
        $manager->persist($tarea);
        $manager->flush();     
        
        $tarea = new Tarea();
        $tarea->setNombre("Compare Versiones");
        $tarea->setDescripcion("Compare Versiones");                
        
        $manager->persist($tarea);
        $manager->flush();             
        
        $tarea = new Tarea();
        $tarea->setNombre("Instalación WAR");
        $tarea->setDescripcion("Instalación WAR");                
        
        $manager->persist($tarea);
        $manager->flush();             
        
        $tarea = new Tarea();
        $tarea->setNombre("Pruebas");
        $tarea->setDescripcion("Set de pruebas");                
        
        $manager->persist($tarea);
        $manager->flush();                    
        
        $tarea = new Tarea();
        $tarea->setNombre("Certificación Scripts");
        $tarea->setDescripcion("Certificación scripts");                
        
        $manager->persist($tarea);
        $manager->flush();          
        
        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(2);
        $tareaUsuario->setIdTarea(1);
        
        $manager->persist($tareaUsuario);
        $manager->flush();            
        
        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(2);
        $tareaUsuario->setIdTarea(2);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(2);
        $tareaUsuario->setIdTarea(3);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(2);
        $tareaUsuario->setIdTarea(4);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(3);
        $tareaUsuario->setIdTarea(5);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(3);
        $tareaUsuario->setIdTarea(6);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         
        
        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(3);
        $tareaUsuario->setIdTarea(7);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(3);
        $tareaUsuario->setIdTarea(8);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(3);
        $tareaUsuario->setIdTarea(9);
        
        $manager->persist($tareaUsuario);
        $manager->flush();         

        $tareaUsuario = new TareaUsuario();
        $tareaUsuario->setIdArea(4);
        $tareaUsuario->setIdTarea(10);
        
        $manager->persist($tareaUsuario);
        $manager->flush();                 
    }
}
