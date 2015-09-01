<?php

namespace soullified\boardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('soullifiedboardBundle:Default:index.html.twig', array('name' => $name));
    }
}
