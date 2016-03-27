<?php

namespace Fonasa\MonitorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Fonasa\MonitorBundle\Entity\Origen;
use Fonasa\MonitorBundle\Entity\Tipo;
use Fonasa\MonitorBundle\Entity\TipoServicio;
use Fonasa\MonitorBundle\Entity\Componente;

use Doctrine\ORM\EntityRepository;

class ServicioType extends AbstractType
{   
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        
        $builder        
            ->add('origen', EntityType::class, array(
                'class' => 'MonitorBundle:Origen',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                //'expanded' => true,
                //'multiple' => false,
                'placeholder' => 'Seleccione una opción...',
                'position' => 'first',
                //'attr' => array('class' => 'form-inline')
            ))                  
            ->add('componente', EntityType::class, array(
                  'class' => 'MonitorBundle:Componente',
                  'choice_label' => 'nombre',                   
                  'placeholder' => 'Seleccione una opción...',
                  'position' => array('after' => 'codigoInterno')
            ))
            ->add('codigoInterno', TextType::class, array(
                  'position' => array('after' => 'tipoServicio'),
                  'disabled' => true,
                ));
        ;
        
        $formModifierTipoServicio = function (FormInterface $form, Origen $origen = null) {
                                    
            $tiposServicio = null === $origen ? array() : $origen->getTiposServicio();                                     
            
            $placeHolder= 'No hay opciones';
            $disabled = true;
            
            if($origen!=null){
                $disabled = false;
                $placeHolder= 'Seleccione una opción...';
            }

            $form->add('tipoServicio', EntityType::class, array(
                       'class'       => 'MonitorBundle:TipoServicio',                       
                       'choices'     => $tiposServicio,
                       'choice_label' => function($tipoServicio, $key, $index) {
                            /** @var Category $category */
                            return $tipoServicio->getTipo()->getNombre();
                        },
                       'choices_as_values' => true,
                       'choice_attr' => function($val, $key, $index) {
                            // adds a class like attending_yes, attending_no, etc
                            return ['idTipo' => $val->getTipo()->getId()];
                        },                                
                       'placeholder' => $placeHolder,                       
                       'disabled' => $disabled,
                       'position' => array('after' => 'origen')
            ));            
        };        
        
        $formModifierAlcance = function (FormInterface $form, Componente $componente = null) {
            
            $alcances = null === $componente ? array() : $componente->getAlcances();             
            
            $placeHolder= 'No hay opciones';
            $disabled = true;
            
            if($componente!=null){
                $disabled = false;
                $placeHolder= 'Seleccione una opción...';
            }

            $form->add('alcance', EntityType::class, array(
                       'class'       => 'MonitorBundle:Alcance',
                       'choices'     => $alcances,
                       'choice_label' => function($alcance, $key, $index) {
                            /** @var Category $category */
                            return $alcance->getTipoAlcance()->getNombre();
                        },
                       'choices_as_values' => true,
                       'choice_attr' => function($val, $key, $index) {
                            // adds a class like attending_yes, attending_no, etc
                            return ['idTipoAlcance' => $val->getTipoAlcance()->getId()];
                        },                                                     
                       'placeholder' => $placeHolder,
                       'disabled' => $disabled,
                       'position' => array('after' => 'componente')
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
            ->add('fechaReporte', DateTimeType::class, array(
            'date_widget'=> 'single_text',
            'date_format'=>'d/M/y' ))
            ->add('prioridad', EntityType::class, array(
                'class' => 'MonitorBundle:Prioridad',                
                'choice_label' => 'nombre',
                //'expanded' => true,
                //'multiple' => false,
                'placeholder' => 'Seleccione una opción...',
                'position' => 'first',
                //'attr' => array('class' => 'form-inline')
            ))  
            ->add('descripcion', TextareaType::class)                                
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
