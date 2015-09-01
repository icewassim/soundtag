<?php

namespace soullified\profilBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

use soullified\profilBundle\Entity\message;
use soullified\profilBundle\Form\messageType;
use soullified\profilBundle\Entity\board;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class messageController extends Controller
{
    public function sendAction($recieverId){

      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();
      $receiverprofil=$em->getRepository('soullifiedprofilBundle:profil')->find($recieverId);
      $formmessage=$this->createForm(new messageType(),new message());

      $boardUrl= $request->request->get('boardUrl');
      $security=$this->container->get('security.context');
      $token=$security->getToken();
      $user=$token->getUser();
      
      if(!$user) return new Response("U need to log In !!") ;
        $sender=$user->getProfil(); /* the connected user profil */

      $roleflagservice=$this->container->get('soullifiedprofil.roleflag');
      $flag=$roleflagservice->getFlag($this->container,$receiverprofil);
        

         

    if($request->getMethod()=='POST')
            {
                        $formmessage->submit($request);
                        $messagedata=$formmessage->getData();
                        $messagedata->setDate(date("Y\-m\-d H:i:s"));
                        $messagedata->setSender($sender);
                        $messagedata->setReceiver($receiverprofil);
                        $messagedata->setSeen(0);
                        $nbr=$receiverprofil->getUnseenmessages();
                        $nbr++;
                        $receiverprofil->setUnseenmessages($nbr);
                        $em->persist($receiverprofil);
                        $em->persist($messagedata);
                        $em->flush();
                         return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$boardUrl)));
                  }

        return new Response('dsqdsq');
    }


    public function getajaxmessagesAction(){

    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $profil=$user->getProfil();

    $repository = $this->getDoctrine()->getManager()->getRepository('soullifiedprofilBundle:message');
    $messages = $repository->findBy(array('receiver' => $profil->getId()),array('id' => 'desc'),3,0);

    $tab=array();
    // $messages=$profil->getMessages();




    $htmlResponse="";
    $notiSeen="";
    $points="";
    /* javascript security Bug !!!! */
    foreach ($messages as $message) {
      array_push($tab,array(
                              "senderId"=>$message->getSender()->getId(),
                              "seen"=>$message->getSeen(),"senderName"=>$message->getSender()->getFullname(),
                              "messageId"=>$message->getId(),
                              "date"=>$message->getDate(),
                              "content"=>substr($message->getContent(),0,30)));
      //$htmlResponse=$htmlResponse."<a href='/inbox/".$message->getSender()->getId()."'  class='notification nothover ".$notiSeen."' notificationId=".$message->getId()." > <b><span href='/profil/".$message->getSender()->getId()."'>".$message->getSender()->getFullname()."</span></b> send you a message<p class='message-content'>".substr($message->getContent(),0,30).$points."</p></span>";
    }


    $return=array("responseCode"=>200,"resultat"=>"sucess","tab"=>$tab);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));

}
    public function getajaxmessagesboxAction(){



    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $profil=$user->getProfil();

    $request=$this->get('request');
    $senderid=$request->get('userid');
    $em =$this->getDoctrine()->getManager();
    $repository = $this->getDoctrine()->getManager()->getRepository('soullifiedprofilBundle:message');
    $messages = $repository->findBy(array('receiver' => $profil->getId(),'sender'=>$senderid,'seen'=>0));

    // $messages=$profil->getMessages();

    $htmlResponse="";
    $notiSeen="";
    $points="";
    $tab=array();
    /* javascript security Bug !!!! */
    foreach ($messages as $message) {
      $message->setSeen(1);
      array_push($tab,array("Id"=>$message->getSender()->getId(),"senderName"=>$message->getSender()->getFullname(),"messageId"=>$message->getId(),"content"=>$message->getContent()));
      $em->persist($message);
    }

    $em->flush();

    $return=array("responseCode"=>200,"tab"=>$tab);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    
    }



    public function declineFrequestAction($requestId){

    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $userId=$user->getProfil()->getId();
    
    $em = $this->getDoctrine()->getManager();
    $frequest=$em->getRepository('soullifiedprofilBundle:message')->find($requestId);
    
    $recieverId=$frequest->getreceiver()->getId();
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
    $frequest=$em->getRepository('soullifiedprofilBundle:message')->find($requestId);
    $friendship=new friendship();
    $friendship2=new friendship();

    $friendship->setFirstfriend($frequest->getSender());
    $friendship->setSecondfriend($frequest->getreceiver());

    $friendship2->setSecondfriend($frequest->getSender());
    $friendship2->setFirstfriend($frequest->getreceiver());

    $recieverId=$frequest->getreceiver()->getId();
    if($recieverId!=$userId)    
        return new Response("U don't have the right to do that !!");

    $em->remove($frequest);
    $em->persist($friendship);
    $em->persist($friendship2);
    $em->flush();
    $return=array("responseCode"=>200,"htmlcode"=>"sucess");
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    
    }



  public function  getUnseenAction(){
      
      // $request=$this->get('request');
      // $em = $this->getDoctrine()->getManager();
      // $profil=$em->getRepository('soullifiedprofilBundle:profil')->find($id);
      $security=$this->container->get('security.context');
      $token=$security->getToken();
      $user=$token->getUser();

      $unseenmessages=$user->getProfil()->getUnseenmessages();
      $unseenevensts=$user->getProfil()->getUnseenevents();
        

      $return=array("responseCode"=>200,"resultat"=>"sucess","unseenmessages"=>$unseenmessages,"unseenevents"=>$unseenevensts);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));

    }


    public function resetUnseenMessagesAction(){
       $security=$this->container->get('security.context');
       $token=$security->getToken();
       $user=$token->getUser();
       $profil=$user->getProfil();
       $profil->setUnseenmessages(0);
       $request=$this->get('request');
       $em = $this->getDoctrine()->getManager();
       $em->persist($profil);  
       $em->flush();  

       $return=array("responseCode"=>200,"resultat"=>"sucess");
       $return=json_encode($return);
       return new Response($return,200,array('Content-Type'=>'application/json'));

    }


    public function resetUnseenEventsAction(){
       $security=$this->container->get('security.context');
       $token=$security->getToken();
       $user=$token->getUser();
       $profil=$user->getProfil();
       $profil->setUnseenevents(0);
       $request=$this->get('request');
       $em = $this->getDoctrine()->getManager();
       $em->persist($profil);  
       $em->flush();  

       $return=array("responseCode"=>200,"resultat"=>"sucess");
       $return=json_encode($return);
       return new Response($return,200,array('Content-Type'=>'application/json'));

    }


    public function viewInboxAction($senderid){

    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $myprofil=$user->getProfil();

    $em = $this->getDoctrine()->getManager();      
    $repo = $em->getRepository('soullifiedprofilBundle:message');
    $messages = $repo->createQueryBuilder('a')
                 ->setParameter('send',$senderid)
                 ->setParameter('receiver',$myprofil->getId())
                 ->setParameter('receiver1',$senderid)
                 ->setParameter('send1',$myprofil->getId())
                 ->select('a')
                 ->andwhere('(a.sender = :send and a.receiver =:receiver) or (a.sender = :send1 and a.receiver =:receiver1)')
                  // ->setParameter('receiver',$myprofil->getId())
                 ->getQuery()
                 ->getResult();


    $tab=array();
    foreach ($messages as $message) {
      $message->setSeen(1);
      $em->persist($message);
    }

    $em->flush();

    $messagesHeaders = $repo->createQueryBuilder('a')
                 ->setParameter('receiver',$myprofil->getId())
                 ->select('a')
                 ->groupBy('a.sender')
                 ->where('( a.receiver =:receiver)')
                 ->getQuery()
                 ->getResult();


    // var_dump(sizeof($messages));
    return $this->render('soullifiedprofilBundle:inbox:inbox.html.twig',
                            array('messages'=>$messages,
                                  'messagesHeaders'=>$messagesHeaders,
                                  'senderid'=>$senderid,
                                  )
                            );
       
    

    }


}