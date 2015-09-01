<?php

namespace soullified\profilBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\profilBundle\Entity\comment;
use soullified\profilBundle\Entity\album;
use soullified\profilBundle\Entity\event;
use soullified\profilBundle\Form\albumType;

use soullified\profilBundle\Entity\friendrequest;
use soullified\profilBundle\Form\friendrequestType;

use soullified\profilBundle\Form\boardType;
use soullified\profilBundle\Form\songType;

use soullified\profilBundle\Entity\friendship;
use soullified\profilBundle\Entity\photo;
use soullified\profilBundle\Entity\song;
use soullified\profilBundle\Entity\board;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class friendrequestController extends Controller
{
    public function sendAction($recieverId){

         $request = $this->getRequest();
         $em = $this->getDoctrine()->getManager();
         $receiverprofil=$em->getRepository('soullifiedprofilBundle:profil')->find($recieverId);
         $formfriendrequest=$this->createForm(new friendrequestType(),new friendrequest());

        $boardUrl= $request->request->get('boardUrl');
        $security=$this->container->get('security.context');
        $token=$security->getToken();
        $user=$token->getUser();
        if(!$user) return new Response("U need to log In !!") ;
        $sender=$user->getProfil();

      $roleflagservice=$this->container->get('soullifiedprofil.roleflag');
      $flag=$roleflagservice->getFlag($this->container,$receiverprofil);
        
        if($flag!="notafriend") return new Response("404 not found");


    if($request->getMethod()=='POST')
            {
                        $formfriendrequest->submit($request);
                        $friendRdata=$formfriendrequest->getData();
                        $friendRdata->setDate(date("Y\-m\-d H:i:s"));
                        $friendRdata->setSender($sender);
                        $friendRdata->setReceiver($receiverprofil);
                        $nbr=$receiverprofil->getUnseenevents();
                        $nbr++;
                        $receiverprofil->setUnseenevents($nbr);
                        $em->persist($receiverprofil);
                        $em->persist($friendRdata);
                        $em->flush();
                         return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$boardUrl)));
                  }

    return new Response('dsqdsq');
    }


    public function getAjaxRequestsAction(){

    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $profil=$user->getProfil();
 
    $frequestsRepository = $this->getDoctrine()->getManager()->getRepository('soullifiedprofilBundle:friendrequest');
    $Frequests = $frequestsRepository->findBy(array('receiver' => $profil->getId()),array('id' => 'desc'),3,0);


    $eventsrRepository = $this->getDoctrine()->getManager()->getRepository('soullifiedprofilBundle:event');
    $events = $eventsrRepository->findBy(array('receiver' => $profil->getId()),array('id' => 'desc'),3,0);

    $htmlResponse="";
    $points="";
    
    foreach ($Frequests as $frequest) {
      if(strlen($frequest->getContent())>25) $points="...";
      else $points="";
      $htmlResponse=$htmlResponse."<div class='notification' notificationId=".$frequest->getId()." > <b><a href=/app_dev.php/life/#/scrapbook/".$frequest->getSender()->getId().">".$frequest->getSender()->getFullname()."</a> </b>send you a Friend Request<p class='message-content'>".substr($frequest->getContent(),0,25).$points."</p><button onclick='acceptRequest(".$frequest->getId().")' class='btn btn-primary btn-sm' style='margin-right:5px;'>Accept request</button><button onclick='cancelRequest(".$frequest->getId().")' class='btn btn-default btn-sm'>Decline</button></div>";

    }

     foreach ($events as $event) {

        if($event->getType()=="comment"){

          if(strlen($event->getContent())>25) $points="...";
          else $points="";
        
          $htmlResponse=$htmlResponse."<div class='notification' notificationId=".$event->getId()." > <b><a href=/app_dev.php/life/#/scrapbook/".$event->getSender()->getUser()->getUsername().">".$event->getSender()->getFullname()."</a> </b>wrote on your  board <p class='message-content'>".substr($event->getContent(),0,25).$points."</p><span class=not-date>".$event->getDate()." ago </span></div>";
        
        }
        

        if($event->getType()=="acceptFrequest"){

          $htmlResponse=$htmlResponse."<div class='notification' notificationId=".$event->getId()." > <b><a href=/app_dev.php/life/#/scrapbook/".$event->getSender()->getUser()->getUsername().">".$event->getSender()->getFullname()."</a> </b>accepted your friend request <span class=not-date >".$event->getDate()." ago</span></div>";
        
        }

    }

    $return=array("responseCode"=>200,"htmlcode"=>"$htmlResponse");
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    

    }


    public function declineFrequestAction($requestId){


    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $userId=$user->getProfil()->getId();
    
    $em = $this->getDoctrine()->getManager();
    $frequest=$em->getRepository('soullifiedprofilBundle:friendrequest')->find($requestId);
    
    $recieverId=$frequest->getReceiver()->getId();
    if($recieverId!=$userId)    
        return new Response("U don't have the right to do that !!");

    $em->remove($frequest);
    $em->flush();
    $return=array("responseCode"=>200,"htmlcode"=>"sucess");
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    
    }



 public function acceptFrequestAction($requestId){


    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $userId=$user->getProfil()->getId();
    $profil=$user->getProfil();

    $em = $this->getDoctrine()->getManager();
    $frequest=$em->getRepository('soullifiedprofilBundle:friendrequest')->find($requestId);
    $friendship=new friendship();
    $friendship2=new friendship();

    $friendship->setFirstfriend($frequest->getSender());
    $friendship->setSecondfriend($frequest->getReceiver());

    $friendship2->setSecondfriend($frequest->getSender());
    $friendship2->setFirstfriend($frequest->getReceiver());

    $event=new event();
    $event->setType("acceptFrequest");
    $event->setSender($frequest->getReceiver());
    $event->setReceiver($frequest->getSender());
    $event->setDate(date("Y\-m\-d H:i:s"));

    $nbr=$frequest->getSender()->getUnseenevents();
    $nbr++;
    $frequest->getSender()->setUnseenevents($nbr);
                    
    $recieverId=$frequest->getReceiver()->getId();
    if($recieverId!=$userId)    
        return new Response("U don't have the right to do that !!");



    $em->remove($frequest);
    $em->persist($event);
    $em->persist($frequest->getSender());
    $em->persist($friendship);
    $em->persist($friendship2);
    $em->flush();
    $return=array("responseCode"=>200,"htmlcode"=>"sucess");
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    
    }

}