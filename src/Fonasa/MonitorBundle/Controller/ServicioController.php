<?php

namespace Fonasa\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Fonasa\MonitorBundle\Entity\Servicio;
use Fonasa\MonitorBundle\Entity\Historial;
use Fonasa\MonitorBundle\Entity\Estado;

use Fonasa\MonitorBundle\Form\ServicioType;

use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Servicio controller.
 *
 */
class ServicioController extends Controller
{
    /**
     * Lists all Servicio entities.
     *
     */
    public function indexAction()
    {                
        return $this->render('MonitorBundle:servicio:index.html.twig');         
    }

    /**
     * Creates a new Servicio entity.
     *
     */
    public function newAction(Request $request)
    {
        $servicio = new Servicio();
        
        $em = $this->getDoctrine()->getManager();        
        
        $form = $this->createForm('Fonasa\MonitorBundle\Form\ServicioType', $servicio, array('assign' => false));
        $form->handleRequest($request);                                

        if ($form->isSubmitted() && $form->isValid()) {
            $codigoInterno=$request->request->get('servicio')['codigoInterno'];
            $fechaIngreso=new\DateTime('now');
            $estado= $em->getRepository('MonitorBundle:Estado')
                ->createQueryBuilder('e')                                
                ->where('e.nombre = ?1')
                ->setParameter(1, 'En Cola')
                ->getQuery()
                ->getResult();
            
            $servicio->setEstado($estado[0]);
            $servicio->setIdEstado($estado[0]->getId());
            $servicio->setCodigoInterno($codigoInterno);
            $servicio->setFechaIngreso($fechaIngreso);
            
            $em = $this->getDoctrine()->getManager();
            $servicioList= $em->persist($servicio);                                    
            $em->flush();
            
            if($servicio->getTipoServicio()->getTipo()->getNombre()=='Resolución Incidencia'){
                $this->addFlash(
                    'notice',
                    'Se ha ingresado un nuevo servicio de tipo Resolución de Incidencia.| El servicio ha sido encolado y puede ser asignado en el panel principal.'
                );   
            }   
            else{
                $this->addFlash(
                    'notice',
                    'Se ha ingresado un nuevo servicio de tipo Mantención.| El servicio ha sido encolado y puede ser asignado en el panel principal.'
                );   
            }

            return $this->redirectToRoute('servicio_show', array('id' => $servicio->getId()));
        }

        return $this->render('MonitorBundle:servicio:new.html.twig', array(
            'servicio' => $servicio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Servicio entity.
     *
     */
    public function showAction(Servicio $servicio)
    {
        $deleteForm = $this->createDeleteForm($servicio);

        return $this->render('MonitorBundle:servicio:show.html.twig', array(
            'servicio' => $servicio,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function editAction(Request $request, Servicio $servicio)
    {
        $deleteForm = $this->createDeleteForm($servicio);
        
        $editForm = $this->createForm('Fonasa\MonitorBundle\Form\ServicioType', $servicio, array('assign' => false));                        
        
        $editForm->handleRequest($request);
                

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush();

            return $this->redirectToRoute('servicio_edit', array('id' => $servicio->getId()));
        }

        return $this->render('MonitorBundle:servicio:edit.html.twig', array(
            'servicio' => $servicio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }     

    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function assignAction(Request $request, Servicio $servicio)
    {                       
        $editForm = $this->createForm('Fonasa\MonitorBundle\Form\ServicioType', $servicio, array('assign' => true));                        
        $editForm->handleRequest($request);                

        if ($editForm->isSubmitted() && $editForm->isValid()) {  
            $em = $this->getDoctrine()->getManager();
            
            if($servicio->getTipoServicio()->getTipo()->getNombre()=='Resolución Incidencia'){
            // Por defecto un servicio de tipo resolucion incidencia es asignado al area de analisis
                $estado= $em->getRepository('MonitorBundle:Estado')
                    ->createQueryBuilder('e')                                
                    ->where('e.nombre = ?1')
                    ->setParameter(1, 'Análisis')
                    ->getQuery()
                    ->getResult();
            }
            else{
                // Por defecto un servicio de tipo mantencion es asignado al area de desarrollo
                $estado= $em->getRepository('MonitorBundle:Estado')
                    ->createQueryBuilder('e')                                
                    ->where('e.nombre = ?1')
                    ->setParameter(1, 'Desa')
                    ->getQuery()
                    ->getResult();
            }            
                                                
            $servicio->setEstado($estado[0]);
            $servicio->setIdEstado($estado[0]->getId());                
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush();
            
            // Guardar el historial del cambio de estado               
            $fechaAsignado=new\DateTime('now');            
            $historial = new Historial();
            
            $historial->setServicio($servicio);                     
            $historial->setIdServicio($servicio->getId());
            $historial->setEstado($estado[0]);
            $historial->setIdEstado($estado[0]->getId());            
            $historial->setInicio($fechaAsignado);                   
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($historial);
            $em->flush();
            
            if($servicio->getTipoServicio()->getTipo()->getNombre()=='Resolución Incidencia'){
                $this->addFlash(
                    'notice',
                    'Se ha asignado un nuevo servicio de tipo Resolución de Incidencia.| El servicio esta actualmente en resolución y puede ser finalizado en el panel principal.'
                );   
            }   
            else{
                $this->addFlash(
                    'notice',
                    'Se ha asignado un nuevo servicio de tipo Mantención.| El servicio está actualmente asignado a desarrollo y puede cambiar su estado en el panel principal'
                );   
            }
            
            return $this->redirectToRoute('servicio_show', array('id' => $servicio->getId()));            
        }                
        
        return $this->render('MonitorBundle:servicio:assign.html.twig', array(
            'servicio' => $servicio,
            'edit_form' => $editForm->createView(),            
        ));        
    }
    
    
    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function finishAction($id)
    {                                           
        
        $em = $this->getDoctrine()->getManager();
        
        $servicio= $em->getRepository('MonitorBundle:Servicio')
            ->createQueryBuilder('s')                                
            ->where('s.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult();                            
                
        $estado= $em->getRepository('MonitorBundle:Estado')
            ->createQueryBuilder('e')                                
            ->where('e.nombre = ?1')
            ->setParameter(1, 'Terminada')
            ->getQuery()
            ->getResult();                    

        $servicio[0]->setEstado($estado[0]);
        $servicio[0]->setIdEstado($estado[0]->getId());                

        $em = $this->getDoctrine()->getManager();
        $em->persist($servicio[0]);
        $em->flush();

        // Guardar el historial del cambio de estado               
        $fechaTerminado=new\DateTime('now');            
        $historial = new Historial();

        $historial->setServicio($servicio[0]);                     
        $historial->setIdServicio($servicio[0]->getId());
        $historial->setEstado($estado[0]);
        $historial->setIdEstado($estado[0]->getId());            
        $historial->setInicio($fechaTerminado);                   

        $em = $this->getDoctrine()->getManager();
        $em->persist($historial);
        $em->flush();

 
        $this->addFlash(
            'notice',
            'Se ha finalizado el servicio '.$servicio[0]->getCodigoInterno().' de tipo Resolución de Incidencia.| El servicio puede ser visualizado en el panel principal mediante el filto "Finalizados".'
        );   
                
        //return $this->render('MonitorBundle:servicio:index.html.twig');                         
        return $this->redirectToRoute('servicio_index');
    }    
        
    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function desaAction($id)
    {                                           
        
        $em = $this->getDoctrine()->getManager();
        
        $servicio= $em->getRepository('MonitorBundle:Servicio')
            ->createQueryBuilder('s')                                
            ->where('s.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult();                            
                
        $estado= $em->getRepository('MonitorBundle:Estado')
            ->createQueryBuilder('e')                                
            ->where('e.nombre = ?1')
            ->setParameter(1, 'Desa')
            ->getQuery()
            ->getResult();                    

        $servicio[0]->setEstado($estado[0]);
        $servicio[0]->setIdEstado($estado[0]->getId());                

        $em = $this->getDoctrine()->getManager();
        $em->persist($servicio[0]);
        $em->flush();

        // Guardar el historial del cambio de estado               
        $fechaTerminado=new\DateTime('now');            
        $historial = new Historial();

        $historial->setServicio($servicio[0]);                     
        $historial->setIdServicio($servicio[0]->getId());
        $historial->setEstado($estado[0]);
        $historial->setIdEstado($estado[0]->getId());            
        $historial->setInicio($fechaTerminado);                   

        $em = $this->getDoctrine()->getManager();
        $em->persist($historial);
        $em->flush();

 
        $this->addFlash(
            'notice',
            'El servicio '.$servicio[0]->getCodigoInterno().' de tipo Mantención ha sido asignado al área de desarrollo.'
        );   
                
        //return $this->render('MonitorBundle:servicio:index.html.twig');                         
        return $this->redirectToRoute('servicio_index');
    }    
        
    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function testAction($id)
    {                                           
        
        $em = $this->getDoctrine()->getManager();
        
        $servicio= $em->getRepository('MonitorBundle:Servicio')
            ->createQueryBuilder('s')                                
            ->where('s.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult();                            
                
        $estado= $em->getRepository('MonitorBundle:Estado')
            ->createQueryBuilder('e')                                
            ->where('e.nombre = ?1')
            ->setParameter(1, 'Test')
            ->getQuery()
            ->getResult();                    

        $servicio[0]->setEstado($estado[0]);
        $servicio[0]->setIdEstado($estado[0]->getId());                

        $em = $this->getDoctrine()->getManager();
        $em->persist($servicio[0]);
        $em->flush();

        // Guardar el historial del cambio de estado               
        $fechaTerminado=new\DateTime('now');            
        $historial = new Historial();

        $historial->setServicio($servicio[0]);                     
        $historial->setIdServicio($servicio[0]->getId());
        $historial->setEstado($estado[0]);
        $historial->setIdEstado($estado[0]->getId());            
        $historial->setInicio($fechaTerminado);                   

        $em = $this->getDoctrine()->getManager();
        $em->persist($historial);
        $em->flush();

 
        $this->addFlash(
            'notice',
            'El servicio '.$servicio[0]->getCodigoInterno().' de tipo Mantención ha sido asignado al área de testing.'
        );   
                
        //return $this->render('MonitorBundle:servicio:index.html.twig');                         
        return $this->redirectToRoute('servicio_index');
    }
    
    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function papAction($id)
    {                                           
        
        $em = $this->getDoctrine()->getManager();
        
        $servicio= $em->getRepository('MonitorBundle:Servicio')
            ->createQueryBuilder('s')                                
            ->where('s.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult();                            
                
        $estado= $em->getRepository('MonitorBundle:Estado')
            ->createQueryBuilder('e')                                
            ->where('e.nombre = ?1')
            ->setParameter(1, 'PaP')
            ->getQuery()
            ->getResult();                    

        $servicio[0]->setEstado($estado[0]);
        $servicio[0]->setIdEstado($estado[0]->getId());                

        $em = $this->getDoctrine()->getManager();
        $em->persist($servicio[0]);
        $em->flush();

        // Guardar el historial del cambio de estado               
        $fechaTerminado=new\DateTime('now');            
        $historial = new Historial();

        $historial->setServicio($servicio[0]);                     
        $historial->setIdServicio($servicio[0]->getId());
        $historial->setEstado($estado[0]);
        $historial->setIdEstado($estado[0]->getId());            
        $historial->setInicio($fechaTerminado);                   

        $em = $this->getDoctrine()->getManager();
        $em->persist($historial);
        $em->flush();

 
        $this->addFlash(
            'notice',
            'El servicio '.$servicio[0]->getCodigoInterno().' de tipo Mantención ha sido agregado a la cola de servicios pendientes por PaP.| Todos los servicios pendientes por PaP pueden ser finalizados en el panel principal.'
        );   
                
        return $this->redirectToRoute('servicio_index');
        //return $this->render('MonitorBundle:servicio:index.html.twig');                         
    }        
    
    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function completeAction()
    {                                           
        
        $em = $this->getDoctrine()->getManager();
        
        $servicios= $em->getRepository('MonitorBundle:Servicio')
            ->createQueryBuilder('s')                             
            ->join('s.estado', 'e')            
            ->where('e.nombre = ?1')
            ->setParameter(1, 'PaP')
            ->getQuery()
            ->getResult();                            
                
        $estado= $em->getRepository('MonitorBundle:Estado')
            ->createQueryBuilder('e')                                
            ->where('e.nombre = ?1')
            ->setParameter(1, 'Terminada')
            ->getQuery()
            ->getResult();        
        
        foreach($servicios as $servicio){
            $servicio->setEstado($estado[0]);
            $servicio->setIdEstado($estado[0]->getId());                

            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush();

            // Guardar el historial del cambio de estado               
            $fechaTerminado=new\DateTime('now');            
            $historial = new Historial();

            $historial->setServicio($servicio);                     
            $historial->setIdServicio($servicio->getId());
            $historial->setEstado($estado[0]);
            $historial->setIdEstado($estado[0]->getId());            
            $historial->setInicio($fechaTerminado);                   

            $em = $this->getDoctrine()->getManager();
            $em->persist($historial);
            $em->flush();    
        }        
 
        $this->addFlash(
            'notice',
            'Todos los servicios en la cola de PaP han sido finalizados.| Estos pueden ser visualizados mediante el filtro finalizados en el panel principal.'
        );   
                
        //return $this->render('MonitorBundle:servicio:index.html.twig');                         
        return $this->redirectToRoute('servicio_index');
    }            

    /**
     * Deletes a Servicio entity.
     *
     */
    public function deleteAction(Request $request, Servicio $servicio)
    {
        $form = $this->createDeleteForm($servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($servicio);
            $em->flush();
        }

        return $this->redirectToRoute('servicio_index');
    }

    /**
     * Creates a form to delete a Servicio entity.
     *
     * @param Servicio $servicio The Servicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Servicio $servicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicio_delete', array('id' => $servicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function checkAction(Request $request){
                
        $codigoInterno= $request->request->get('codigoInterno');
        $id= $request->request->get('id');
        
        $error = false;
        $message = "Código válido";        
        
        if (!preg_match('(^Ticket[0-9]+|^SIGG-MC[0-9]+|^SIGG-ME[0-9]+|^RFC[0-9]+)',$codigoInterno)){ 
            $error = true;
            $message = 'Código de formato no válido';            
        }             
        
        if(!$error){
            $em = $this->getDoctrine()->getManager();                    
            //Si se esta editando o asignando un servicio se debe proveer el id del servicio
            if($id != null){                
                $servicio= $em->getRepository('MonitorBundle:Servicio')
                ->createQueryBuilder('s')                                
                ->where('s.codigoInterno = ?1')
                ->andWhere('s.id <> ?2')
                ->setParameter(1, $codigoInterno)
                ->setParameter(2, $id)                        
                ->getQuery()
                ->getResult();
            }
            else{
                $servicio= $em->getRepository('MonitorBundle:Servicio')
                ->createQueryBuilder('s')                                
                ->where('s.codigoInterno = ?1')
                ->setParameter(1, $codigoInterno)
                ->getQuery()
                ->getResult();                
            }                        

            if(!empty($servicio)){
                $error = true;
                $message = 'Ya existe un servicio con este código';                
            }                    
        }        
        return new JsonResponse(array('error' => $error, 'message' => $message));                
    }        
    
    public function bodyAction(Request $request){
        
        //Obtener parámetros de DataTables
        $sSearch= $request->query->get('sSearch');
        $iSortCol= $request->query->get('iSortCol_0');
        $sSortDir= $request->query->get('sSortDir_0');        
        
        //Obtener parámetros de filtros
        $anio= $request->query->get('anio');
        $mes= $request->query->get('mes');
        $estado= $request->query->get('estado');        
        //////////////////                
        
        $em = $this->getDoctrine()->getManager();                
        
        $parameters = array();                

        $qb = $em->getRepository('MonitorBundle:Servicio')
                ->createQueryBuilder('s')                
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('YEAR(s.fechaReporte) = ?1')
                ->andWhere('MONTH(s.fechaReporte) = ?2')
                ->andWhere('e.nombre in (?3)');
        
        $parameters[1] = $anio;
        
        $parameters[2] = $mes;
        
        if($estado == 1)
            $parameters[3]=['En Cola','Análisis','Desa','Test','PaP'];
        else
            $parameters[3]=['Terminada'];
    
        if($sSearch != null){            
            $qb->andWhere(
            $qb->expr()->orx(
            $qb->expr()->like('s.codigoInterno', '?4'),
            $qb->expr()->like('t.nombre', '?4'),
            $qb->expr()->like('s.fechaReporte', '?4'),
            $qb->expr()->like('o.nombre', '?4'),            
            $qb->expr()->like('p.nombre', '?4'),
            $qb->expr()->like('e.descripcion', '?4')
           ));
            
           $parameters[4]='%'.$sSearch.'%'; 
        }
        
        if($iSortCol != null){
            
            switch($iSortCol){
                case '0':
                    $qb->orderBy('s.codigoInterno', $sSortDir);
                    break;
                case '1':
                    $qb->orderBy('s.fechaReporte', $sSortDir);
                    break;                
                case '2':
                    $qb->orderBy('o.nombre', $sSortDir);
                    break;
                case '3':
                    $qb->orderBy('t.nombre', $sSortDir);
                    break;
                case '4':
                    $qb->orderBy('p.nombre', $sSortDir);
                    break;
                case '5':
                    $qb->orderBy('e.descripcion', $sSortDir);
                    break;
            }
        }
                
        $servicios= $qb->setParameters($parameters)
                    ->getQuery()
                    ->getResult();   
        
        $estados = $em->getRepository('MonitorBundle:Estado')
                ->createQueryBuilder('e')                                
                ->where('e.nombre in (?1)')
                ->setParameter(1, ['Desa','Test','PaP'])
                ->getQuery()
                ->getResult();   
        
        $body = array();              
        $cont = 0;
        
        $hayPaP = false;
        
        foreach($servicios as $servicio){
            $fila = array();  
            
            array_push($fila,$servicio->getCodigoInterno());
            array_push($fila,$servicio->getFechaReporte()->format('d/m/Y H:i'));
            //array_push($fila,$servicio->getComponente()->getNombre());
            array_push($fila,$servicio->getOrigen()->getNombre());
            array_push($fila,$servicio->getTipoServicio()->getTipo()->getNombre());
            array_push($fila,$servicio->getPrioridad()->getNombre());                                                
                        
            switch($servicio->getEstado()->getNombre()){

                case 'En Cola':
                    array_push($fila,'<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:0%"><span class="black-font">'.$servicio->getEstado()->getDescripcion().'</span></div></div>');
                    array_push($fila,'<a id="'.$servicio->getId().'" href="'.$this->generateUrl('servicio_assign', array('id' => $servicio->getId())).'" role="button" class="btn btn-primary">Asignar</button>');                                        
                    break;
                case 'Análisis':                        
                    array_push($fila,'<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"><span>'.$servicio->getEstado()->getDescripcion().'</span></div></div>');
                    array_push($fila,'<a href="'.$this->generateUrl('servicio_finish', array('id' => $servicio->getId())).'" role="button" class="btn btn-warning">Finalizar</button>');                    
                    break;
                case 'Desa':
                case 'Test':
                case 'PaP':
                    if($servicio->getEstado()->getNombre()=='PaP')
                        $hayPaP=true;
                    array_push($fila,'<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"><span>'.$servicio->getEstado()->getDescripcion().'</span></div></div>');
                    $html='<div class="btn-group">';
                    foreach($estados as $estado)                        
                    {
                        if($estado->getNombre()==$servicio->getEstado()->getNombre())
                            $class='btn btn-sm btn-primary';
                        else
                            $class='btn btn-sm btn-default';
                        $html=$html.'<a href="'.$this->generateUrl('servicio_'.strtolower($estado->getNombre()), array('id' => $servicio->getId())).'" role="button" class="'.$class.'">'.$estado->getNombre().'</button>';
                    }
                    $html=$html.'</div>';

                    array_push($fila,$html);                        

                    break;
                case 'Terminada':
                    array_push($fila,'<div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"><span>'.$servicio->getEstado()->getDescripcion().'</span></div></div>');
                    $html='<div class="btn-group">';
                    foreach($estados as $estado)                        
                    {
                        
                        $class='btn btn-sm btn-default';
                        $html=$html.'<a href="'.$this->generateUrl('servicio_'.strtolower($estado->getNombre()), array('id' => $servicio->getId())).'" role="button" class="'.$class.'">'.$estado->getNombre().'</button>';
                    }
                    $html=$html.'</div>';

                    array_push($fila,$html);                        
            }                   
            
            array_push($fila,'<ul><li><a href="'.$this->generateUrl('servicio_show', array('id' => $servicio->getId())).'">ver</a></li><li><a href="'.$this->generateUrl('servicio_edit', array('id' => $servicio->getId())).'">editar</a></li></ul>');
            
            array_push($body, $fila);
            $cont++;
        }
        
        $pap = null;
                        
        if($hayPaP)
            $pap = '<a href="'.$this->generateUrl('servicio_complete').'" role="button" class="btn btn-link">Finalizar servicios pendientes para PaP</button>';
        
        $output= array(
          'sEcho' => intval($request->request->get('sEcho')),
          'iTotalRecords' => $cont,
          'iTotalDisplayRecords' => $cont,  
          'aaData' => $body,
          'pap' => $pap
        );
        
        return new JsonResponse($output);
    }
}
