<?php

namespace Fonasa\MonitorBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Controller\TraceableControllerResolver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ControllerListener
{    
        
    protected $router;
    protected $security;        
    protected $resolver;
    protected $tokenStorage;
 
    public function __construct(Router $router, AuthorizationChecker $security, TraceableControllerResolver $resolver,
                                TokenStorage $tokenStorage = null) {
        $this->router = $router;		
        $this->security = $security;                
        $this->resolver = $resolver;
        $this->tokenStorage = $tokenStorage;
    }
        
    public function onKernelController(FilterControllerEvent $event)
    {        	
        $request = $event->getRequest();                                        
        $routeName = $request->getPathInfo('_route');                
        
        if ($this->tokenStorage->getToken() != null && explode('/',$routeName)[1] == "login" && 
            $this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
                        
            $event->setController($this->resolver->getController($request));						
            $request->attributes->set('_controller', 'MonitorBundle:Dashboard:index');
            $request->attributes->set('_route', $this->router->generate('dashboard_index'));
            $event->setController($this->resolver->getController($request));						                        
        }
                       
    }
}