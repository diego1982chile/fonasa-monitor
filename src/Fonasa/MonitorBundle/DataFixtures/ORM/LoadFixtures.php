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
use Fonasa\MonitorBundle\Entity\Servicio;
use Fonasa\MonitorBundle\Entity\Modulo;
use Fonasa\MonitorBundle\Entity\ModuloSistema;
use Fonasa\MonitorBundle\Entity\Impacto;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoadFixtures extends Controller implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        
        $connection->exec("ALTER TABLE area AUTO_INCREMENT = 1;");
        
        $area1 = new Area();
                
        $area1->setNombre("Análisis");
        $area1->setDescripcion("Área encargada de analizar y gestionar los requerimientos y/o incidencias, generando mantenciones asociadas");        
        
        $manager->persist($area1);        

        $area2 = new Area();                
        $area2->setNombre("Desarrollo");        
        $area2->setDescripcion("Área encargada de desarrollar las mantenciones generadas por el área de análisis");        

        $manager->persist($area2);        
                
        $area3 = new Area();                
        $area3->setNombre("Testing");
        $area3->setDescripcion("Área encargada de testear las mantenciones generadas por el área de desarrollo");                        

        $manager->persist($area3);         
                
        $area4 = new Area();                
        $area4->setNombre("Explotación");
        $area4->setDescripcion("Área encargada de certificar las mantenciones generadas por testing y realizar PaP");                
        
        $manager->persist($area4);
        $manager->flush(); 
                
        $connection->exec("ALTER TABLE estado AUTO_INCREMENT = 1;");
        
        $estado1 = new Estado();                
        $estado1->setNombre("En Cola");
        $estado1->setDescripcion("Por asignar a desarrollo");                
        
        $manager->persist($estado1);
        $manager->flush();   
        
        $estado1 = new Estado();              
        $estado1->setNombre("Desarrollo");
        $estado1->setDescripcion("Asignada a desarrollo");                
        
        $manager->persist($estado1);
        $manager->flush();               
                
        $estado2 = new Estado();              
        $estado2->setNombre("Testing");
        $estado2->setDescripcion("En testing");                
        
        $manager->persist($estado2);
        $manager->flush();                 
                
        $estado3 = new Estado();              
        $estado3->setNombre("Explotación");
        $estado3->setDescripcion("En certificación");                
        
        $manager->persist($estado3);
        $manager->flush();                       
                
        $estado4 = new Estado();              
        $estado4->setNombre("Pendiente PaP");
        $estado4->setDescripcion("Pendiente aprobación PaP");                
        
        $manager->persist($estado4);
        $manager->flush();           
                
        $estado5 = new Estado();              
        $estado5->setNombre("Terminada");
        $estado5->setDescripcion("Terminada");                
        
        $manager->persist($estado5);
        $manager->flush();     
        
        $connection->exec("ALTER TABLE origen AUTO_INCREMENT = 1;");
        
        $origen1 = new Origen();                
        $origen1->setNombre("Req. FONASA");
        $origen1->setDescripcion("Requerimiento FONASA");                
        
        $manager->persist($origen1);
        $manager->flush();         
        
        $origen2 = new Origen();                
        $origen2->setNombre("Req. MINSAL");
        $origen2->setDescripcion("Requerimiento FONASA");                
        
        $manager->persist($origen2);
        $manager->flush();         
                
        $origen3 = new Origen();              
        $origen3->setNombre("Mesa");
        $origen3->setDescripcion("Mesa de ayuda");                
        
        $manager->persist($origen3);
        $manager->flush();       
        
        $connection->exec("ALTER TABLE prioridad AUTO_INCREMENT = 1;");        
        
        $prioridad1 = new Prioridad();
        $prioridad1->setNombre("Alta");
        $prioridad1->setDescripcion("Prioridad alta");                
        
        $manager->persist($prioridad1);
        $manager->flush();            
        
        $prioridad2 = new Prioridad();
        $prioridad2->setNombre("Media");
        $prioridad2->setDescripcion("Prioridad media");                
        
        $manager->persist($prioridad2);
        $manager->flush();                  
                
        $prioridad3 = new Prioridad();
        $prioridad3->setNombre("Baja");
        $prioridad3->setDescripcion("Prioridad baja");                
        
        $manager->persist($prioridad3);
        $manager->flush();                  
        
        $connection->exec("ALTER TABLE impacto AUTO_INCREMENT = 1;");                        
        
        $impacto1 = new Impacto();
        $impacto1->setNombre("Alto");
        $impacto1->setDescripcion("Alto");                
        
        $manager->persist($impacto1);
        $manager->flush();     
        
        $impacto2 = new Impacto();
        $impacto2->setNombre("Medio");
        $impacto2->setDescripcion("Medio");                
        
        $manager->persist($impacto2);
        $manager->flush();        
        
        $impacto3 = new Impacto();
        $impacto3->setNombre("Leve");
        $impacto3->setDescripcion("Leve");                
        
        $manager->persist($impacto3);
        $manager->flush();                
        
        $connection->exec("ALTER TABLE sistema AUTO_INCREMENT = 1;");                                        
        
        $sistema1 = new Sistema();
        $sistema1->setNombre("SIGGES");
        $sistema1->setDescripcion("Sistema de monitoreo de Garantias de Oportunidad");                
        
        $manager->persist($sistema1);
        $manager->flush();        
                
        $sistema2 = new Sistema();
        $sistema2->setNombre("GGPF");
        $sistema2->setDescripcion("Sistema de monitoreo de Garantias financieras");                                
        
        $manager->persist($sistema2);
        $manager->flush();                
        
        $sistema3 = new Sistema();
        $sistema3->setNombre("Préstamo Médico");
        $sistema3->setDescripcion("Préstamo Médico");                                
        
        $manager->persist($sistema3);
        $manager->flush();                
        
        $sistema4 = new Sistema();
        $sistema4->setNombre("DWH");
        $sistema4->setDescripcion("DWH");                                
        
        $manager->persist($sistema4);
        $manager->flush();                        
        
        $connection->exec("ALTER TABLE tipo AUTO_INCREMENT = 1;");                                                        
        
        $tipo1 = new Tipo();
        $tipo1->setNombre("Incidencia");
        $tipo1->setDescripcion("Incidencia");                
        
        $manager->persist($tipo1);
        $manager->flush();  
        
        $tipo2 = new Tipo();
        $tipo2->setNombre("Mantención Correctiva");
        $tipo2->setDescripcion("Mantención correctiva");                
        
        $manager->persist($tipo2);
        $manager->flush();          
                
        $tipo3 = new Tipo();
        $tipo3->setNombre("Mantención Evolutiva");
        $tipo3->setDescripcion("Mantención evolutiva");                
        
        $manager->persist($tipo3);
        $manager->flush();                  
                
        $tipo4 = new Tipo();     
        $tipo4->setNombre("Mantención Adaptativa");
        $tipo4->setDescripcion("Mantención Adaptativa");                
        
        $manager->persist($tipo4);
        $manager->flush();                   
        
        $connection->exec("ALTER TABLE servicio AUTO_INCREMENT = 1;");                                                        
                        
        $servicio1 = new Servicio();
        $servicio1->setOrigen($origen1);
        $servicio1->setIdOrigen($origen1->getId());        
        $servicio1->setTipo($tipo1);
        $servicio1->setIdTipo($tipo1->getId());        
                
        $manager->persist($servicio1);
        $manager->flush();                       
        
        $servicio2 = new Servicio();
        $servicio2->setOrigen($origen1);
        $servicio2->setIdOrigen($origen1->getId());        
        $servicio2->setTipo($tipo2);
        $servicio2->setIdTipo($tipo2->getId());                                     
        
        $manager->persist($servicio2);
        $manager->flush();                
        
        $servicio3 = new Servicio();
        $servicio3->setOrigen($origen2);
        $servicio3->setIdOrigen($origen2->getId());        
        $servicio3->setTipo($tipo2);
        $servicio3->setIdTipo($tipo2->getId());                                              
        
        $manager->persist($servicio3);
        $manager->flush();      
        
        $servicio4 = new Servicio();
        $servicio4->setOrigen($origen2);
        $servicio4->setIdOrigen($origen2->getId());        
        $servicio4->setTipo($tipo3);
        $servicio4->setIdTipo($tipo3->getId());                                             
        
        $manager->persist($servicio4);
        $manager->flush();            

        $connection->exec("ALTER TABLE tarea AUTO_INCREMENT = 1;");                                                                        
        
        $tarea1 = new Tarea();
        $tarea1->setNombre("Análisis y diseño");
        $tarea1->setDescripcion("Análisis y diseño");                
        
        $manager->persist($tarea1);
        $manager->flush();  
                
        $tarea2 = new Tarea();
        $tarea2->setNombre("Preparación Scripts");
        $tarea2->setDescripcion("Preparación Scripts");                
        
        $manager->persist($tarea2);
        $manager->flush();          
                
        $tarea3 = new Tarea();
        $tarea3->setNombre("Preparación Documentación");
        $tarea3->setDescripcion("Preparación Documentación");                
        
        $manager->persist($tarea3);
        $manager->flush();          
                
        $tarea4 = new Tarea();
        $tarea4->setNombre("Generación WAR y CD");
        $tarea4->setDescripcion("Generación WAR y CD");                
        
        $manager->persist($tarea4);
        $manager->flush();  
                
        $tarea5 = new Tarea();
        $tarea5->setNombre("Revisión documentación");
        $tarea5->setDescripcion("Revisión documentación");                
        
        $manager->persist($tarea5);
        $manager->flush();             
                
        $tarea6 = new Tarea();
        $tarea6->setNombre("Revisión Scripts");
        $tarea6->setDescripcion("Revisión Scripts");                
        
        $manager->persist($tarea6);
        $manager->flush();     
                
        $tarea7 = new Tarea();
        $tarea7->setNombre("Compare Versiones");
        $tarea7->setDescripcion("Compare Versiones");                
        
        $manager->persist($tarea7);
        $manager->flush();             
                
        $tarea8 = new Tarea();
        $tarea8->setNombre("Instalación WAR");
        $tarea8->setDescripcion("Instalación WAR");                
        
        $manager->persist($tarea8);
        $manager->flush();             
                
        $tarea9 = new Tarea();
        $tarea9->setNombre("Pruebas");
        $tarea9->setDescripcion("Set de pruebas");                
        
        $manager->persist($tarea9);
        $manager->flush();                    
                
        $tarea10 = new Tarea();
        $tarea10->setNombre("Certificación Scripts");
        $tarea10->setDescripcion("Certificación scripts");                
        
        $manager->persist($tarea10);
        $manager->flush();          
        
        $connection->exec("ALTER TABLE tarea_usuario AUTO_INCREMENT = 1;");                                                                                        
        
        $tareaUsuario1 = new TareaUsuario();
        $tareaUsuario1->setArea($area2);
        $tareaUsuario1->setIdArea($area2->getId());        
        $tareaUsuario1->setTarea($tarea1);
        $tareaUsuario1->setIdTarea($tarea1->getId());             
        
        $manager->persist($tareaUsuario1);
        $manager->flush();            
        
        $tareaUsuario2 = new TareaUsuario();
        $tareaUsuario2->setArea($area2);
        $tareaUsuario2->setIdArea($area2->getId());        
        $tareaUsuario2->setTarea($tarea2);
        $tareaUsuario2->setIdTarea($tarea2->getId());                     
        
        $manager->persist($tareaUsuario2);
        $manager->flush();         
        
        $tareaUsuario3 = new TareaUsuario();
        $tareaUsuario3->setArea($area2);
        $tareaUsuario3->setIdArea($area2->getId());        
        $tareaUsuario3->setTarea($tarea3);
        $tareaUsuario3->setIdTarea($tarea3->getId());                     
        
        $manager->persist($tareaUsuario3);
        $manager->flush();         
        
        $tareaUsuario4 = new TareaUsuario();
        $tareaUsuario4->setArea($area2);
        $tareaUsuario4->setIdArea($area2->getId());        
        $tareaUsuario4->setTarea($tarea4);
        $tareaUsuario4->setIdTarea($tarea4->getId());                     
        
        $manager->persist($tareaUsuario4);
        $manager->flush();         
        
        $tareaUsuario5 = new TareaUsuario();
        $tareaUsuario5->setArea($area3);
        $tareaUsuario5->setIdArea($area3->getId());        
        $tareaUsuario5->setTarea($tarea5);
        $tareaUsuario5->setIdTarea($tarea5->getId());                     
        
        $manager->persist($tareaUsuario5);
        $manager->flush();         
        
        $tareaUsuario6 = new TareaUsuario();
        $tareaUsuario6->setArea($area3);
        $tareaUsuario6->setIdArea($area3->getId());        
        $tareaUsuario6->setTarea($tarea6);
        $tareaUsuario6->setIdTarea($tarea6->getId());                             
        
        $manager->persist($tareaUsuario6);
        $manager->flush();         
        
        $tareaUsuario7 = new TareaUsuario();
        $tareaUsuario7->setArea($area3);
        $tareaUsuario7->setIdArea($area3->getId());        
        $tareaUsuario7->setTarea($tarea7);
        $tareaUsuario7->setIdTarea($tarea7->getId());                                     
        
        $manager->persist($tareaUsuario7);
        $manager->flush();         
        
        $tareaUsuario8 = new TareaUsuario();
        $tareaUsuario8->setArea($area3);
        $tareaUsuario8->setIdArea($area3->getId());        
        $tareaUsuario8->setTarea($tarea8);
        $tareaUsuario8->setIdTarea($tarea8->getId());             
        
        $manager->persist($tareaUsuario8);
        $manager->flush();         
        
        $tareaUsuario9 = new TareaUsuario();
        $tareaUsuario9->setArea($area3);
        $tareaUsuario9->setIdArea($area3->getId());        
        $tareaUsuario9->setTarea($tarea9);
        $tareaUsuario9->setIdTarea($tarea9->getId());                     
        
        $manager->persist($tareaUsuario9);
        $manager->flush();         
        
        $tareaUsuario10 = new TareaUsuario();
        $tareaUsuario10->setArea($area4);
        $tareaUsuario10->setIdArea($area4->getId());        
        $tareaUsuario10->setTarea($tarea10);
        $tareaUsuario10->setIdTarea($tarea10->getId());                             
        
        $manager->persist($tareaUsuario10);
        $manager->flush();                 
        
        $connection->exec("ALTER TABLE modulo AUTO_INCREMENT = 1;");                
        
        $modulo1 = new Modulo();
        $modulo1->setNombre("ACR Consulta");
        $modulo1->setDescripcion("ACR Consulta");                
        
        $manager->persist($modulo1);
        $manager->flush();                         
        
        $modulo2 = new Modulo();   
        $modulo2->setNombre("Adm. Establecimiento");
        $modulo2->setDescripcion("Adm. Establecimiento");                
        
        $manager->persist($modulo2);
        $manager->flush();                           
                
        $modulo3 = new Modulo();
        $modulo3->setNombre("Adm. Colas");
        $modulo3->setDescripcion("Adm. Colas");                
        
        $manager->persist($modulo3);
        $manager->flush();                 
                
        $modulo4 = new Modulo();
        $modulo4->setNombre("Arancel");
        $modulo4->setDescripcion("Arancel");                
        
        $manager->persist($modulo4);
        $manager->flush();              
                
        $modulo5 = new Modulo();
        $modulo5->setNombre("Beneficiario");
        $modulo5->setDescripcion("Beneficiario");                
        
        $manager->persist($modulo5);
        $manager->flush();                   
                
        $modulo6 = new Modulo();
        $modulo6->setNombre("Búsqueda paciente");
        $modulo6->setDescripcion("Búsqueda paciente");                
        
        $manager->persist($modulo6);
        $manager->flush();        
                
        $modulo7 = new Modulo();
        $modulo7->setNombre("CAT");
        $modulo7->setDescripcion("CAT");                
        
        $manager->persist($modulo7);
        $manager->flush();              
                
        $modulo8 = new Modulo();
        $modulo8->setNombre("CUP");
        $modulo8->setDescripcion("CUP");                
        
        $manager->persist($modulo8);
        $manager->flush();          
        
        $modulo9 = new Modulo();
        $modulo9->setNombre("Datamart");
        $modulo9->setDescripcion("Datamart");                
        
        $manager->persist($modulo9);
        $manager->flush();               
                
        $modulo10 = new Modulo();
        $modulo10->setNombre("DDE");
        $modulo10->setDescripcion("DDE");                
        
        $manager->persist($modulo10);
        $manager->flush();          
        
        $modulo11 = new Modulo();
        $modulo11->setNombre("Desbloqueo prev. fallecido");
        $modulo11->setDescripcion("Desbloqueo prev. fallecido");                
        
        $manager->persist($modulo11);
        $manager->flush();                  
                
        $modulo12 = new Modulo();
        $modulo12->setNombre("ENDECA");
        $modulo12->setDescripcion("ENDECA");                
        
        $manager->persist($modulo12);
        $manager->flush();                  
                
        $modulo13 = new Modulo();
        $modulo13->setNombre("Extracción");
        $modulo13->setDescripcion("Extracción");                
        
        $manager->persist($modulo13);
        $manager->flush();                     
                
        $modulo14 = new Modulo();
        $modulo14->setNombre("EXTRAEGGPF");
        $modulo14->setDescripcion("EXTRAEGGPF");                
        
        $manager->persist($modulo14);
        $manager->flush();                         
                
        $modulo15 = new Modulo();
        $modulo15->setNombre("Facturación");
        $modulo15->setDescripcion("Facturación");                
        
        $manager->persist($modulo15);
        $manager->flush();                  
                
        $modulo16 = new Modulo();
        $modulo16->setNombre("Parametrización eventos GO");
        $modulo16->setDescripcion("Parametrización eventos GO");                
        
        $manager->persist($modulo16);
        $manager->flush();                  
                
        $modulo17 = new Modulo();
        $modulo17->setNombre("IFL");
        $modulo17->setDescripcion("IFL");                
        
        $manager->persist($modulo17);
        $manager->flush();                 
                
        $modulo18 = new Modulo();
        $modulo18->setNombre("Manuales");
        $modulo18->setDescripcion("Manuales");                
        
        $manager->persist($modulo18);
        $manager->flush();                         
                
        $modulo19 = new Modulo();
        $modulo19->setNombre("Monitoreo y consultas");
        $modulo19->setDescripcion("Monitoreo y consultas");                
        
        $manager->persist($modulo19);
        $manager->flush();                       
                
        $modulo20 = new Modulo();
        $modulo20->setNombre("Reporte OFF-Line");
        $modulo20->setDescripcion("Reporte OFF-Line");                
        
        $manager->persist($modulo20);
        $manager->flush();                               
                
        $modulo21 = new Modulo();
        $modulo21->setNombre("RNP");
        $modulo21->setDescripcion("RNP");                
        
        $manager->persist($modulo21);
        $manager->flush();                               
                
        $modulo22 = new Modulo();    
        $modulo22->setNombre("POII-POIM");
        $modulo22->setDescripcion("POII-POIM");                
        
        $manager->persist($modulo22);
        $manager->flush();          
                
        $modulo23 = new Modulo();
        $modulo23->setNombre("Recálculo GO");
        $modulo23->setDescripcion("Recálculo GO");                
        
        $manager->persist($modulo23);
        $manager->flush();                  
                
        $modulo24 = new Modulo();
        $modulo24->setNombre("Revalorizar");
        $modulo24->setDescripcion("Revalorizar");                
        
        $manager->persist($modulo24);
        $manager->flush();                          
                
        $modulo25 = new Modulo();
        $modulo25->setNombre("Proceso CAC");
        $modulo25->setDescripcion("Proceso CAC");                
        
        $manager->persist($modulo25);
        $manager->flush();                          
                
        $modulo26 = new Modulo();
        $modulo26->setNombre("VIH");
        $modulo26->setDescripcion("VIH");                
        
        $manager->persist($modulo26);
        $manager->flush();                          
                
        $modulo27 = new Modulo();
        $modulo27->setNombre("WS Certificador Prev.");
        $modulo27->setDescripcion("WS Certificador Prev.");                
        
        $manager->persist($modulo27);
        $manager->flush();                  
        
        $connection->exec("ALTER TABLE modulo_sistema AUTO_INCREMENT = 1;");                                
                        
        $moduloSistema1 = new ModuloSistema();
        $moduloSistema1->setSistema($sistema1);
        $moduloSistema1->setIdSistema($sistema1->getId());
        $moduloSistema1->setModulo($modulo1);        
        $moduloSistema1->setIdModulo($modulo1->getId());
        
        $manager->persist($moduloSistema1);
        $manager->flush();                          
        
        $moduloSistema2 = new ModuloSistema();
        $moduloSistema2->setSistema($sistema1);
        $moduloSistema2->setIdSistema($sistema1->getId());
        $moduloSistema2->setModulo($modulo2);        
        $moduloSistema2->setIdModulo($modulo2->getId());                
        
        $manager->persist($moduloSistema2);
        $manager->flush();                      
                
        $moduloSistema3 = new ModuloSistema();
        $moduloSistema3->setSistema($sistema1);
        $moduloSistema3->setIdSistema($sistema1->getId());
        $moduloSistema3->setModulo($modulo3);        
        $moduloSistema3->setIdModulo($modulo3->getId());        
        
        $manager->persist($moduloSistema3);
        $manager->flush();         
        
        $moduloSistema4 = new ModuloSistema();
        $moduloSistema4->setSistema($sistema1);
        $moduloSistema4->setIdSistema($sistema1->getId());
        $moduloSistema4->setModulo($modulo4);        
        $moduloSistema4->setIdModulo($modulo4->getId());                
        
        $manager->persist($moduloSistema4);
        $manager->flush();         
        
        $moduloSistema5 = new ModuloSistema();
        $moduloSistema5->setSistema($sistema1);
        $moduloSistema5->setIdSistema($sistema1->getId());
        $moduloSistema5->setModulo($modulo5);        
        $moduloSistema5->setIdModulo($modulo5->getId());                        
        
        $manager->persist($moduloSistema5);
        $manager->flush();         
        
        $moduloSistema6 = new ModuloSistema();
        $moduloSistema6->setSistema($sistema1);
        $moduloSistema6->setIdSistema($sistema1->getId());
        $moduloSistema6->setModulo($modulo6);        
        $moduloSistema6->setIdModulo($modulo6->getId());                        
        
        $manager->persist($moduloSistema6);
        $manager->flush();         
        
        $moduloSistema7 = new ModuloSistema();
        $moduloSistema7->setSistema($sistema1);
        $moduloSistema7->setIdSistema($sistema1->getId());
        $moduloSistema7->setModulo($modulo7);        
        $moduloSistema7->setIdModulo($modulo7->getId());                        
        
        $manager->persist($moduloSistema7);
        $manager->flush();         
        
        $moduloSistema8 = new ModuloSistema();
        $moduloSistema8->setSistema($sistema1);
        $moduloSistema8->setIdSistema($sistema1->getId());
        $moduloSistema8->setModulo($modulo8);        
        $moduloSistema8->setIdModulo($modulo8->getId());                        
        
        $manager->persist($moduloSistema8);
        $manager->flush();         
        
        $moduloSistema9 = new ModuloSistema();
        $moduloSistema9->setSistema($sistema1);
        $moduloSistema9->setIdSistema($sistema1->getId());
        $moduloSistema9->setModulo($modulo9);        
        $moduloSistema9->setIdModulo($modulo9->getId());                        
        
        $manager->persist($moduloSistema9);
        $manager->flush();         
        
        $moduloSistema10 = new ModuloSistema();
        $moduloSistema10->setSistema($sistema1);
        $moduloSistema10->setIdSistema($sistema1->getId());
        $moduloSistema10->setModulo($modulo10);        
        $moduloSistema10->setIdModulo($modulo10->getId());        
                
        $manager->persist($moduloSistema10);
        $manager->flush();          
        
        $moduloSistema11 = new ModuloSistema();
        $moduloSistema11->setSistema($sistema1);
        $moduloSistema11->setIdSistema($sistema1->getId());
        $moduloSistema11->setModulo($modulo11);        
        $moduloSistema11->setIdModulo($modulo11->getId());                        
        
        $manager->persist($moduloSistema11);
        $manager->flush();          
        
        $moduloSistema12 = new ModuloSistema();
        $moduloSistema12->setSistema($sistema1);
        $moduloSistema12->setIdSistema($sistema1->getId());
        $moduloSistema12->setModulo($modulo12);        
        $moduloSistema12->setIdModulo($modulo12->getId());                                
        
        $manager->persist($moduloSistema12);
        $manager->flush();         
        
        $moduloSistema13 = new ModuloSistema();
        $moduloSistema13->setSistema($sistema1);
        $moduloSistema13->setIdSistema($sistema1->getId());
        $moduloSistema13->setModulo($modulo13);        
        $moduloSistema13->setIdModulo($modulo13->getId());                        
        
        $manager->persist($moduloSistema13);
        $manager->flush();      
        
        $moduloSistema14 = new ModuloSistema();
        $moduloSistema14->setSistema($sistema1);
        $moduloSistema14->setIdSistema($sistema1->getId());
        $moduloSistema14->setModulo($modulo14);        
        $moduloSistema14->setIdModulo($modulo14->getId());                       
        
        $manager->persist($moduloSistema14);
        $manager->flush();          
        
        $moduloSistema15 = new ModuloSistema();
        $moduloSistema15->setSistema($sistema1);
        $moduloSistema15->setIdSistema($sistema1->getId());
        $moduloSistema15->setModulo($modulo15);        
        $moduloSistema15->setIdModulo($modulo15->getId());                                
        
        $manager->persist($moduloSistema15);
        $manager->flush();          
        
        $moduloSistema16 = new ModuloSistema();
        $moduloSistema16->setSistema($sistema1);
        $moduloSistema16->setIdSistema($sistema1->getId());
        $moduloSistema16->setModulo($modulo16);        
        $moduloSistema16->setIdModulo($modulo16->getId());                                
        
        $manager->persist($moduloSistema16);
        $manager->flush();          
        
        $moduloSistema17 = new ModuloSistema();
        $moduloSistema17->setSistema($sistema1);
        $moduloSistema17->setIdSistema($sistema1->getId());
        $moduloSistema17->setModulo($modulo17);        
        $moduloSistema17->setIdModulo($modulo17->getId());                                
        
        $manager->persist($moduloSistema17);
        $manager->flush();          
        
        $moduloSistema18 = new ModuloSistema();
        $moduloSistema18->setSistema($sistema1);
        $moduloSistema18->setIdSistema($sistema1->getId());
        $moduloSistema18->setModulo($modulo18);        
        $moduloSistema18->setIdModulo($modulo18->getId());                                
        
        $manager->persist($moduloSistema18);
        $manager->flush();          
        
        $moduloSistema19 = new ModuloSistema();
        $moduloSistema19->setSistema($sistema1);
        $moduloSistema19->setIdSistema($sistema1->getId());
        $moduloSistema19->setModulo($modulo19);        
        $moduloSistema19->setIdModulo($modulo19->getId());                                
        
        $manager->persist($moduloSistema19);
        $manager->flush();                 
        
        $moduloSistema20 = new ModuloSistema();
        $moduloSistema20->setSistema($sistema1);
        $moduloSistema20->setIdSistema($sistema1->getId());
        $moduloSistema20->setModulo($modulo20);        
        $moduloSistema20->setIdModulo($modulo20->getId());                               
        
        $manager->persist($moduloSistema20);
        $manager->flush();          
        
        $moduloSistema21 = new ModuloSistema();
        $moduloSistema21->setSistema($sistema1);
        $moduloSistema21->setIdSistema($sistema1->getId());
        $moduloSistema21->setModulo($modulo21);        
        $moduloSistema21->setIdModulo($modulo21->getId());                                               
        
        $manager->persist($moduloSistema21);
        $manager->flush();          
        
        $moduloSistema22 = new ModuloSistema();
        $moduloSistema22->setSistema($sistema1);
        $moduloSistema22->setIdSistema($sistema1->getId());
        $moduloSistema22->setModulo($modulo22);        
        $moduloSistema22->setIdModulo($modulo22->getId());                                                       
        
        $manager->persist($moduloSistema22);
        $manager->flush();          
        
        $moduloSistema23 = new ModuloSistema();
        $moduloSistema23->setSistema($sistema1);
        $moduloSistema23->setIdSistema($sistema1->getId());
        $moduloSistema23->setModulo($modulo23);        
        $moduloSistema23->setIdModulo($modulo23->getId());                                                       
        
        $manager->persist($moduloSistema23);
        $manager->flush();          
        
        $moduloSistema24 = new ModuloSistema();
        $moduloSistema24->setSistema($sistema1);
        $moduloSistema24->setIdSistema($sistema1->getId());
        $moduloSistema24->setModulo($modulo24);        
        $moduloSistema24->setIdModulo($modulo24->getId());                                                       
        
        $manager->persist($moduloSistema24);
        $manager->flush();          
        
        $moduloSistema25 = new ModuloSistema();
        $moduloSistema25->setSistema($sistema1);
        $moduloSistema25->setIdSistema($sistema1->getId());
        $moduloSistema25->setModulo($modulo25);        
        $moduloSistema25->setIdModulo($modulo25->getId());                                                       
        
        $manager->persist($moduloSistema25);
        $manager->flush();          
        
        $moduloSistema26 = new ModuloSistema();
        $moduloSistema26->setSistema($sistema1);
        $moduloSistema26->setIdSistema($sistema1->getId());
        $moduloSistema26->setModulo($modulo26);        
        $moduloSistema26->setIdModulo($modulo26->getId());                                                               
        
        $manager->persist($moduloSistema26);
        $manager->flush();          
        
        $moduloSistema27 = new ModuloSistema();
        $moduloSistema27->setSistema($sistema1);
        $moduloSistema27->setIdSistema($sistema1->getId());
        $moduloSistema27->setModulo($modulo27);        
        $moduloSistema27->setIdModulo($modulo27->getId());                                               
        
        $manager->persist($moduloSistema27);
        $manager->flush();     
        
    }
}
