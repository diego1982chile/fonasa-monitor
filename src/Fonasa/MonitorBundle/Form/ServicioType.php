<?php

namespace Fonasa\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Fonasa\MonitorBundle\Entity\Origen;
use Fonasa\MonitorBundle\Entity\Tipo;
use Fonasa\MonitorBundle\Entity\TipoServicio;
use Fonasa\MonitorBundle\Entity\Componente;

class ServicioType extends AbstractType
{   
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        
        $builder                                    
            ->add('componente', EntityType::class, array(
                  'class' => 'MonitorBundle:Componente',
                  'choice_label' => 'nombre',
                  'placeholder' => 'Seleccione una opción...',
                  'position' => 'first'
            ))          
            ->add('origen', EntityType::class, array(
                'class' => 'MonitorBundle:Origen',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione una opción...',
                'position' => array('after' => 'componente')
            ));        
        ;
        
        $formModifierTipoServicio = function (FormInterface $form, Origen $origen = null) {
            
            $tiposServicio = null === $origen ? array() : $origen->getTiposServicio(); 
            $tipos = array();
            
            foreach ($tiposServicio as $r)
            {                
                array_push($tipos,$r->getTipo());
            }

            $form->add('tipoServicio', EntityType::class, array(
                       'class'       => 'MonitorBundle:Tipo',
                       'placeholder' => '',
                       'choices'     => $tipos,
                       'choice_label' => 'nombre',
                       'placeholder' => 'Seleccione una opción...',
                       'position' => array('after' => 'origen')
            ));            
        };        
        
        $formModifierAlcance = function (FormInterface $form, Componente $componente = null) {
            
            $alcances = null === $componente ? array() : $componente->getAlcances(); 
            $tiposAlcance = array();
            
            foreach ($alcances as $r)
            {                
                array_push($tiposAlcance,$r->getTipoAlcance());
            }

            $form->add('alcance', EntityType::class, array(
                       'class'       => 'MonitorBundle:TipoAlcance',
                       'placeholder' => '',
                       'choices'     => $tiposAlcance,
                       'choice_label' => 'nombre',
                       'placeholder' => 'Seleccione una opción...',
                       'position' => array('after' => 'tipoServicio')
            ));            
        };        
        
        $builder                        
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifierTipoServicio, $formModifierAlcance) {                    
                    // this would be your entity, i.e. SportMeetup
                    $data = $event->getData();
                    
                    $formModifierTipoServicio($event->getForm(), $data->getOrigen());                    
                    $formModifierAlcance($event->getForm(), $data->getComponente());                    
                }
            );
            
        $builder                                    
            ->get('origen')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifierTipoServicio) {
                    // It's important here to fetch $event->getForm()->getData(), as
                    // $event->getData() will get you the client data (that is, the ID)
                    $origen = $event->getForm()->getData();

                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                    $formModifierTipoServicio($event->getForm()->getParent(), $origen);                    
                }
            );
        
        $builder                                    
            ->get('componente')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifierAlcance) {
                    // It's important here to fetch $event->getForm()->getData(), as
                    // $event->getData() will get you the client data (that is, the ID)
                    $componente = $event->getForm()->getData();

                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                    $formModifierAlcance($event->getForm()->getParent(), $componente);                    
                }
            );            
        
        $builder                                        
            ->add('codigoInterno')
            ->add('fechaReporte', DateTimeType::class)    
            ->add('descripcion', TextareaType::class)                    
            //->add('prioridad')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array('data_class' => 'Fonasa\MonitorBundle\Entity\Servicio'));
    }
       
    
}
