<?php

namespace Fonasa\MonitorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Fonasa\MonitorBundle\Entity\Servicio;
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
        $em = $this->getDoctrine()->getManager();

        $servicios = $em->getRepository('MonitorBundle:Servicio')
                ->createQueryBuilder('s')                
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('e.nombre = ?1')
                ->setParameter(1, 'En Cola')
                ->getQuery()
                ->getResult();                
        
        return $this->render('MonitorBundle:servicio:index.html.twig', array(
            'servicios' => $servicios,
        ));
    }

    /**
     * Creates a new Servicio entity.
     *
     */
    public function newAction(Request $request)
    {
        $servicio = new Servicio();
        
        $em = $this->getDoctrine()->getManager();        
        
        $form = $this->createForm('Fonasa\MonitorBundle\Form\ServicioType', $servicio);
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
        $editForm = $this->createForm('Fonasa\MonitorBundle\Form\ServicioType', $servicio);
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
        $error = false;
        $message = "";        
        
        if (!preg_match('(^Ticket[0-9]+|^SIGG-MC[0-9]+|^SIGG-ME[0-9]+|^RFC[0-9]+)',$codigoInterno)){ 
            $error = true;
            $message = 'Código de formato no válido';            
        }             
        
        if(!$error){
            $em = $this->getDoctrine()->getManager();        
            $servicio= $em->getRepository('MonitorBundle:Servicio')
                            ->createQueryBuilder('s')                                
                            ->where('s.codigoInterno = ?1')
                            ->setParameter(1, $codigoInterno)
                            ->getQuery()
                            ->getResult();

            if(!empty($servicio)){
                $error = true;
                $message = 'Ya existe un servicio con este código';                
            }                    
        }        
        return new JsonResponse(array('error' => $error, 'message' => $message));                
    }
    
    public function bodyAction(Request $request){
        
        //Obtener parámetros
        $sSearch= $request->request->get('codigoInterno');
        $iSortCol= $request->request->get('codigoInterno');
        $sSortDir= $request->request->get('codigoInterno');
        $codigoInterno= $request->request->get('codigoInterno');
        $codigoInterno= $request->request->get('codigoInterno');
        //////////////////
        
        $em = $this->getDoctrine()->getManager();

        $servicios = $em->getRepository('MonitorBundle:Servicio')
                ->createQueryBuilder('s')                
                ->join('s.tipoServicio', 'ts')
                ->join('ts.tipo', 't')
                ->join('s.estado', 'e')
                ->join('s.componente', 'c')
                ->join('s.prioridad', 'p')
                ->join('s.origen', 'o')
                ->where('e.nombre = ?1')
                ->setParameter(1, 'En Cola')
                ->getQuery()
                ->getResult();   
        
        $estados = $em->getRepository('MonitorBundle:Estado')
                ->createQueryBuilder('e')                                
                ->getQuery()
                ->getResult();   
        
        $body = array();              
        $cont = 0;
        
        foreach($servicios as $servicio){
            $fila = array();  
            
            array_push($fila,$servicio->getCodigoInterno());
            array_push($fila,$servicio->getFechaReporte()->format('d/m/Y H:i'));
            array_push($fila,$servicio->getComponente()->getNombre());
            array_push($fila,$servicio->getOrigen()->getNombre());
            array_push($fila,$servicio->getTipoServicio()->getTipo()->getNombre());
            array_push($fila,$servicio->getPrioridad()->getNombre());
            if($servicio->getTipoServicio()->getTipo()->getNombre()=='Incidencia')
                array_push($fila,'<button id="'.$servicio->getId().'" type="button" class="btn btn-success">Resuelta</button>');
            else
            {
                if(in_array($servicio->getEstado()->getNombre(),['En Cola','Terminada']))
                    array_push($fila,'<a id="'.$servicio->getId().'" href="'.$this->generateUrl('servicio_assign', array('id' => $servicio->getId())).'" role="button" class="btn btn-primary">Asignar</button>');
                else
                {
                    $html='<div class="btn-group">';
                    foreach($estados as $estado)
                    {
                        $html=$html.'<button type="button" class="btn btn-primary">'.$estado->getNombre().'</button>';
                    }
                    $html=$html.'</div>';
                    
                    array_push($fila,$html);
                }
                    
            }                            
            array_push($fila,'<ul><li><a href="'.$this->generateUrl('servicio_show', array('id' => $servicio->getId())).'">ver</a></li><li><a href="'.$this->generateUrl('servicio_edit', array('id' => $servicio->getId())).'">editar</a></li></ul>');
            
            array_push($body, $fila);
            $cont++;
        } 
                        
        
        $output= array(
          'sEcho' => intval($request->request->get('sEcho')),
          'iTotalRecords' => $cont,
          'iTotalDisplayRecords' => $cont,  
          'aaData' => $body
        );
        
        return new JsonResponse($output);
    }
}
