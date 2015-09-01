<?php

namespace soullified\lifesoundtrackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('soullifiedlifesoundtrackBundle:Default:index.html.twig', array('name' => $name));
    }
}
