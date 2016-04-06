<?php

namespace Fonasa\MonitorBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class RequestListener
{
    protected $router;
    protected $security;    
    protected $tokenStorage;
 
    public function __construct(Router $router, AuthorizationChecker $security, TokenStorage $tokenStorage = null) {
        $this->router = $router;
        $this->security = $security;   
        $this->tokenStorage = $tokenStorage;
    }
        
    public function onKernelRequest(GetResponseEvent $event)
    {                        
        
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            // don't do anything if it's not the master request
            return;
        }
                                
        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route');                
                
        if($routeName === "fos_user_security_login" && $this->security->isGranted('ROLE_USER')){
            $url = $this->router->generate('dashboard_index');
            $event->setResponse(new RedirectResponse($url));
        }
        else if($routeName === "fos_user_security_login" && $this->security->isGranted('ROLE_ADMIN')){
            $url = $this->router->generate('servicio_index');
            $event->setResponse(new RedirectResponse($url));
        }              
    }
}