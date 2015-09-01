<?php

namespace soullified\boardBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\boardBundle\Entity\comment;
use soullified\boardBundle\Entity\album;
use soullified\boardBundle\Form\albumType;
use soullified\boardBundle\Form\boardType;

use soullified\boardBundle\Form\songType;

use soullified\profilBundle\Entity\friendrequest;
use soullified\profilBundle\Form\friendrequestType;

use soullified\profilBundle\Entity\message;
use soullified\profilBundle\Form\messageType;

use Symfony\Component\Filesystem\Filesystem;

use soullified\boardBundle\Entity\photo;
use soullified\boardBundle\Entity\song;
use soullified\boardBundle\Entity\board;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class searchController extends Controller
{
    
   public function searchBoardAction(){

   $request = $this->getRequest();
   $key_words=$request->get('query');


  // $key_words="strong";
  $em = $this->getDoctrine()->getManager();      
  $repo = $em->getRepository('soullifiedboardBundle:board');
  $results = $repo->createQueryBuilder('a')
               ->select('a.title,a.url')
               ->where('a.title LIKE :title')
               ->andWhere('a.isprofil = 0 ')
               ->setParameter('title', '%'.$key_words.'%')
               ->getQuery()
               ->getResult();


  $suggestions=array();

  foreach ($results as $value) {
    $suggestions[]=array("val"=>$value["title"],"url"=>$value["url"]);
  }


     $return=array("responseCode"=>200,"query"=>$key_words,"suggestions"=>$suggestions);
          $return=json_encode($return);
          return new Response($return,200,array('Content-Type'=>'application/json'));
       
  }

}