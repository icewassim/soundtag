<?php

namespace soullified\boardBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\boardBundle\Entity\comment;
use soullified\boardBundle\Entity\album;
use soullified\profilBundle\Entity\event;
use soullified\boardBundle\Form\albumType;
use soullified\boardBundle\Form\boardType;
use soullified\boardBundle\Entity\board;
use soullified\boardBundle\Entity\host;
use soullified\boardBundle\Entity\subcomment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class subcommentController extends Controller
{
  public function addsubcommentAction(){
    $request=$this->get('request');
		$em =$this->getDoctrine()->getManager();
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $comment=new comment();
    $profil=NULL;
    $subcomment = new subcomment();
   if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
              $user=$token->getUser();
              $profil=$user->getProfil();  
              $comment->setOwner($profil);
         }
    else
        {
          $name = $request->request->get("guestName");
          $hostVatar= $request->request->get("guestAvatar");
          $host = new host();
          $host->setFullname($name);
          $host->setAvatar($hostVatar);
          $subcomment->setHost($host);
          $em->persist($host);
        }

    $commentId = $request->request->get('commentId');
    $content = $request->request->get('content');
    $comment = $em->getRepository('soullifiedboardBundle:comment')->find($commentId);
    $subcomment->setContent($content);
    $subcomment->setOwner($profil);
    $subcomment->setDate(date("Y\-m\-d H:i:s"));
    $subcomment->setComment($comment);
    $comment->addSubcomment($subcomment);
    $em->persist($comment);
    $em->flush();
    $return=array("responseCode"=>200,"commentId"=>$commentId);
		$return=json_encode($return);
		return new Response($return,200,array('Content-Type'=>'application/json'));
 }

public function rmSubCommentAction()
{
  $request=$this->get('request');
  $em = $this->getDoctrine()->getManager();
  $subcommentId=$request->get('subcommentId');
  $subcomment = $em->getRepository('soullifiedboardBundle:subcomment')->find($subcommentId);
  $comment=$subcomment->getComment();
  $comment->removeSubcomment($subcomment);
  $em->remove($subcomment);
  $em->persist($comment);
  $em->flush();
}

 public function getCommentContentAction()
{
  $request=$this->get('request');
  $em = $this->getDoctrine()->getManager();
  $commentId=$request->get('commentId');
  $em = $this->getDoctrine()->getManager();
  $comment =$em->getRepository("soullifiedboardBundle:comment")->find($commentId);
  $retComment =
  $return=array("responseCode"=>200,
                "comment"=>$retComment,
                );
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}


 public function getSubCommentsAction()
 {
    $request=$this->get('request');
    $commentId = $request->get('commentId');
    $request=$this->get('request');
    $em =$this->getDoctrine()->getManager();
    $comment = $em->getRepository('soullifiedboardBundle:comment')->find($commentId);
    $subcommentsArray = array();
    array_push($subcommentsArray, 
                array('description' =>$comment->getlongtitle(),
                      'content' =>$comment->getContent(),
                      "date"=>$comment->getDate(),
                      "Id"=>$comment->getId(),
                      "ownerId"=>$comment->getOwner()?$comment->getOwner()->getUser()->getUsername():-1,
                      "ownername"=>$comment->getOwner()?$comment->getOwner()->getFullname():$comment->getHost()->getFullname(),
                      "ownerPicture"=>$comment->getOwner()?$comment->getOwner()->getProfilPicture():$comment->getHost()->getAvatar(),
                      )
                );

    foreach ($comment->getSubcomments() as $subcomment) {
      array_push($subcommentsArray,array('content' => $subcomment->getContent(),
                                         "date"=>$subcomment->getDate(),
                                         "ownerId"=>$subcomment->getOwner()?$subcomment->getOwner()->getId():-1,
                                         "ownername"=>$subcomment->getOwner()?$subcomment->getOwner()->getFullname():$subcomment->getHost()->getFullname(),
                                         "ownerPicture"=>$subcomment->getOwner()?$subcomment->getOwner()->getProfilPicture():$subcomment->getHost()->getAvatar(),
                                         "Id"=>$subcomment->getId(),
                                         )

          );
      
    }

    $return=array("responseCode"=>200,"subcommentsArray"=>$subcommentsArray);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));  
 }
}