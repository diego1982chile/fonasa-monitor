<?php

namespace Fonasa\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Fonasa\MonitorBundle\Entity\Origen;

class MantencionType extends AbstractType
{   
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        
        $builder                                    
            ->add('sistema', EntityType::class, array(
                'class' => 'MonitorBundle:Sistema',
                'choice_label' => 'nombre'
            ))          
            ->add('origen', EntityType::class, array(
                'class' => 'MonitorBundle:Origen',
                'choice_label' => 'nombre'
            ));        
        ;
        
        $formModifier = function (FormInterface $form, Origen $origen = null) {
            
            $servicios = null === $origen ? array() : $origen->getServicios();                        

            $form->add('servicio', EntityType::class, array(
                       'class'       => 'MonitorBundle:Servicio',
                       'placeholder' => '',
                       'choices'     => $servicios,
            ));
            
            echo("PASE");
        };        
                        
        $builder                        
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier) {                    
                    // this would be your entity, i.e. SportMeetup
                    $data = $event->getData();
                    
                    $formModifier($event->getForm(), $data->getOrigen());                    
                }
            );
            
        $builder                                    
            ->get('origen')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier) {
                    // It's important here to fetch $event->getForm()->getData(), as
                    // $event->getData() will get you the client data (that is, the ID)
                    $origen = $event->getForm()->getData();

                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                    $formModifier($event->getForm()->getParent(), $origen);
                }
            );
                
        $builder                                        
            ->add('codigoExterno')
            ->add('codigoInterno')
            ->add('descripcion')            
            ->add('fechaReporte', DateTimeType::class)            
            //->add('prioridad')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array('data_class' => 'Fonasa\MonitorBundle\Entity\Mantencion'));
    }
       
    
}
