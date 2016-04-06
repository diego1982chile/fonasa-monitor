<?php

namespace Fonasa\MonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
         //Obtener parámetros de filtros
        //$anio= $request->query->get('anio');
        //$mes= $request->query->get('mes');
        //$estado= $request->query->get('estado');        
        //////////////////                
        
        $em = $this->getDoctrine()->getManager();                
        
        ///////////// PRIMER CHART: INCIDENCIAS POR COMPONENTE/////////////////
        
        // Obtener categorias
        $componentes = $em->getRepository('MonitorBundle:Componente')
        ->createQueryBuilder('c')                                        
        ->orderBy('c.nombre')
        ->getQuery()
        ->getResult();   
        
        // Obtener stacks
        $estados = $em->getRepository('MonitorBundle:Estado')
        ->createQueryBuilder('e')                                
        ->where('e.nombre in (?1)')
        ->setParameter(1, ['En cola','PaP','Terminada'])
        ->getQuery()
        ->getResult();   
        
        // Obtener data
        $parameters = array();                

        $qb = $em->getRepository('MonitorBundle:Servicio')                
                ->createQueryBuilder('s')                
                ->select('c.nombre as componente, e.nombre estado, count(s.id) as cantidad')
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('t.nombre = ?1')                
                ->andWhere('e.nombre in (?2)');
        
        $qb->groupBy('c.nombre');
        $qb->groupBy('e.nombre');
        
        $parameters[1] = 'Resolución Incidencia';                
                
        $parameters[2]=['En Cola','PaP','Terminada'];
        
        $incidencias= $qb->setParameters($parameters)
                    ->getQuery()    
                    ->getResult();   
        
        $data = array();                       
        
        $incidencias_= array();
        
        foreach($incidencias as $incidencia)
            $incidencias_[$incidencia['estado']][$incidencia['componente']]=$incidencia['cantidad'];                   
        
        $categories = array();
        
        // Estructurar respuesta para HighCharts 
        foreach($estados as $estado){        
            $data_ = array();            
            foreach($componentes as $componente){     
                $categories[]=$componente->getNombre();
                if(array_key_exists($estado->getNombre(), $incidencias_)){
                    $incidencias__=$incidencias_[$estado->getNombre()];
                    if(array_key_exists($componente->getNombre(), $incidencias__))                            
                        array_push($data_,$incidencias__[$componente->getNombre()]);                        
                    else
                        array_push($data_, "0");
                }
                else 
                    array_push($data_, "0");                                    
            }
            $data[$estado->getNombre()]=$data_;
        }        
                        
        return $this->render('MonitorBundle:Dashboard:index.html.twig',
        array(
            'chartIncidenciasComponente' => array('categories' => $categories, 'data' => $data
            )
        ));                                        
    }
}
