<?php

namespace soullified\boardBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\boardBundle\Entity\comment;
use soullified\boardBundle\Entity\dashboard;
use soullified\boardBundle\Form\photoType;
use soullified\boardBundle\Form\boardType;

use soullified\profilBundle\Entity\friendrequest;
use soullified\profilBundle\Form\friendrequestType;

use soullified\profilBundle\Entity\message;
use soullified\profilBundle\Form\messageType;

use Symfony\Component\Filesystem\Filesystem;

use soullified\boardBundle\Entity\photo;
use soullified\boardBundle\Entity\board;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class guestController extends Controller
{
 
  public function addNewGuestAction(){
    $request = $this->getRequest();
    $name=$request->request->get("name");
    $email=$request->request->get("email");
    $guest->setName($name);
    $guest->setEmail($email);
    $em = $this->getDoctrine()->getManager();
    $em->persist($guest);
    $em->flush();
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
   }
}