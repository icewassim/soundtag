<?php

namespace soullified\UserBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoggedInUserListener
{
    private $router;
    private $container;

    public function __construct($router, $container)
    {
        $this->router = $router;
        $this->container = $container;
    }    

    public function onKernelRequest(GetResponseEvent $event)
    {
        $container = $this->container;
        $accountRouteName = "show_home_page";
        if( $container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            // authenticated (NON anonymous)
            $routeName = $container->get('request')->get('_route');
            if ($routeName != $accountRouteName) {
                $url = $this->router->generate($accountRouteName);
                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}