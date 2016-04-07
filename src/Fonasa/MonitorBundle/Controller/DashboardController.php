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
        
        ///////////// 1er CHART: INCIDENCIAS POR COMPONENTE/////////////////
        
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
        ->setParameter(1, ['En Gestión FONASA','Pendiente MT','Resuelta MT'])
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
                
        $parameters[2] = ['En Gestión FONASA','Pendiente MT','Resuelta MT'];
        
        $incidencias= $qb->setParameters($parameters)
                    ->getQuery()    
                    ->getResult();                   
        
        $incidencias_= array();
        
        foreach($incidencias as $incidencia)
            $incidencias_[$incidencia['estado']][$incidencia['componente']]=$incidencia['cantidad'];                                   
        
        // Preparar respuesta para HighCharts 
        $series1 = array();                       
        
        foreach($estados as $estado){        
            $data_ = array();            
            $categories1 = array();
            foreach($componentes as $componente){     
                array_push($categories1, $componente->getNombre());
                if(array_key_exists($estado->getNombre(), $incidencias_)){
                    $incidencias__=$incidencias_[$estado->getNombre()];
                    if(array_key_exists($componente->getNombre(), $incidencias__))                            
                        array_push($data_,intval($incidencias__[$componente->getNombre()]));                        
                    else
                        array_push($data_, 0);
                }
                else 
                    array_push($data_, 0);                                    
            }
            $series1[]=array('name' => $estado->getNombre(), 'data' => $data_);
        }                        
        
         ///////////// 2° CHART: INCIDENCIAS POR ESTADO/////////////////
        
        //Obtener Data
        
        //Obtener total incidencias
        $qb = $em->getRepository('MonitorBundle:Servicio')                
                ->createQueryBuilder('s')                
                ->select('count(s.id) as total')
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('t.nombre = ?1')                
                ->andWhere('e.nombre in (?2)');
        
        $parameters[1] = 'Resolución Incidencia';       
        $parameters[2] = ['En Gestión FONASA','Pendiente MT','Resuelta MT'];
        
        $totals= $qb->setParameters($parameters)
                    ->getQuery()    
                    ->getResult();            
        
        $total= $totals[0]['total'];
        
        $parameters = array();                

        $qb = $em->getRepository('MonitorBundle:Servicio')                
                ->createQueryBuilder('s')                
                ->select('e.nombre estado, 100*(count(s.id)/?3) as porcentaje')
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('t.nombre = ?1')                
                ->andWhere('e.nombre in (?2)');
                
        $qb->groupBy('e.nombre');
        
        $parameters[1] = 'Resolución Incidencia';                
                
        $parameters[2] = ['En Gestión FONASA','Pendiente MT','Resuelta MT'];
        
        $parameters[3] = $total;
                        
        $incidencias= $qb->setParameters($parameters)
                    ->getQuery()    
                    ->getResult();                   
        
        $incidencias_= array();
        
        foreach($incidencias as $incidencia)
            $incidencias_[$incidencia['estado']]=$incidencia['porcentaje'];
        
        // Preparar respuesta para HighCharts 
        $series2 = array('name' => 'Brands', 'colorByPoint' => true);                               
        
        $data = array();
        
        foreach($estados as $estado){                    
            $data_ = array();                                 
            if(array_key_exists($estado->getNombre(), $incidencias_)){
                $incidencias__=$incidencias_[$estado->getNombre()];
                array_push($data_,$incidencias_[$estado->getNombre()]);
            }
            else {
                array_push($data_, 0);
            }                        
            $data[]=array('name' => $estado->getNombre(), 'y' => intval($data_[0]));
            
        }   
                
        $series2['data'] = $data;
        
        ///////////// 2° CHART: TIEMPOS DE RESOLUCIÓN DE INCIDENCIAS/////////////////
        
        $categories2 = $categories1;
        
        // Categorias
        array_unshift($categories2, 'Todos');
        
        // Obtener datos Todos
        $qb = $em->getRepository('MonitorBundle:Servicio')                
                ->createQueryBuilder('s')                
                ->select('s.hhEfectivas as tiempo, count(s.id) as cantidad')
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('t.nombre = ?1')                
                ->andWhere('e.nombre in (?2)');
                
        $qb->groupBy('s.hhEfectivas');
        
        $parameters = array();
        
        $parameters[1] = 'Resolución Incidencia';                
                
        $parameters[2] = ['Resuelta MT'];                
                        
        $incidencias= $qb->setParameters($parameters)
                    ->getQuery()    
                    ->getResult();                   
        
        $incidencias_= array();
        
        foreach($incidencias as $incidencia)
            $incidencias_['Todos'][$incidencia['tiempo']]=$incidencia['cantidad'];
        
        // Obtener datos por componente
        $qb = $em->getRepository('MonitorBundle:Servicio')                
                ->createQueryBuilder('s')                
                ->select('c.nombre componente, s.hhEfectivas as tiempo, count(s.id) as cantidad')
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('t.nombre = ?1')                
                ->andWhere('e.nombre in (?2)');
                
        $qb->groupBy('c.nombre');        
        $qb->groupBy('s.hhEfectivas');        
        
        $parameters = array();
        
        $parameters[1] = 'Resolución Incidencia';                
                
        $parameters[2] = ['Resuelta MT'];                
                        
        $incidencias= $qb->setParameters($parameters)
                    ->getQuery()    
                    ->getResult();          
        
        foreach($incidencias as $incidencia)
            $incidencias_[$incidencia['componente']][$incidencia['tiempo']]=$incidencia['cantidad'];
        
        // Preparar respuesta para HighCharts 
        $series3 = array();                       
        
        foreach($categories2 as $categoria){        
            $data_ = array();                        
            $categories3 = array();
            for($i=0;$i<11;++$i){                 
                $categories3[] = $i.'hrs';
                if(array_key_exists($categoria, $incidencias_)){
                    $incidencias__=$incidencias_[$categoria];
                    if(array_key_exists($i, $incidencias__)){
                        array_push($data_,intval($incidencias__[$i]));  
                    }
                    else{
                        array_push($data_, 0);
                    }
                }
                else{
                    array_push($data_, 0);
                }                
            }
            $series3[]=array('name' => $categoria, 'data' => $data_);
        }                                
                                
        return $this->render('MonitorBundle:Dashboard:index.html.twig',
        array(
            'chartIncidenciasComponente' => array('title'      => json_encode('Incidencias por Componente/Fecha de Hoy'),
                                                  'yAxis'      => json_encode('Total Incidencias'),
                                                  'categories' => json_encode($categories1), 
                                                  'series'     => json_encode($series1)),
            'chartIncidenciasEstado'     => array('title'      => json_encode('Incidencias por Estado/Semanal'),
                                                  //'yAxis'      => json_encode('Total Incidencias'),
                                                  //'categories' => json_encode($categories), 
                                                  'series'     => json_encode([$series2])),
            'chartTiemposResIncidencias' => array('title' => json_encode('Tiempos de Resolución Incidencias/Semanal'),
                                                  'yAxis'      => json_encode('Cantidad de Incidencias'),
                                                  'categories' => json_encode($categories3), 
                                                  'series'     => json_encode($series3))
        ));                                        
    }
}
