<?php

namespace Fonasa\MonitorBundle\EventListener;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
	
	protected $router;
	protected $security;
	
	public function __construct(Router $router, AuthorizationChecker $security)
	{
		$this->router = $router;
		$this->security = $security;
	}
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		
		if ($this->security->isGranted('ROLE_SUPER_ADMIN'))
		{
			// $response = new RedirectResponse($this->router->generate('algo'));
			$response = new Response("NO PERMITIDO");
			//SE DESLOGEA
			$this->security->setToken(null);
			$request->getSession()->invalidate();
		}
		else if ($this->security->isGranted('ROLE_ADMIN'))
		{
			$response = new RedirectResponse($this->router->generate('monitor_homepage'));
		} 
		else if ($this->security->isGranted('ROLE_USER'))
		{
			// redirect the user to where they were before the login process begun.
			// $referer_url = $request->headers->get('referer');
			$referer_url = $this->router->generate('monitor_homepage');
						
			$response = new RedirectResponse($referer_url);
		}
		return $response;
	}
	
}