<?php

namespace soullified\boardBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\boardBundle\Entity\comment;
use soullified\boardBundle\Entity\album;
use soullified\boardBundle\Form\albumType;
use soullified\boardBundle\Form\boardType;

use soullified\boardBundle\Form\songType;
use soullified\boardBundle\Form\communityboardType;
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

class communityboardController extends Controller
{
    
   public function addnewboardAction(){

   $request = $this->getRequest();
   $em = $this->getDoctrine()->getManager();      
   $security=$this->container->get('security.context');
   $token=$security->getToken();
   $user=$token->getUser();
   $profil=$user->getProfil();
   $board=new board();
   $board->setprofil($profil);
   $em->persist($board);
   $em->flush();

    $formboard=$this->createForm(new boardType(),new board());

    $posting=new album();
    $formalbum=$this->createForm(new albumType(),new album()); 
    $formsong=$this->createForm(new songType(),new song());      
    $isNew=true;
      

      $editId = $this->getRequest()->get('editId');

        if (!preg_match('/^\d+$/', $editId))
        {
            $isNew=false;
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($posting->getId())
            {
                
                $this->get('punk_ave.file_uploader')->syncFiles(
                    array('from_folder' => 'attachments/' . $posting->getId(), 
                          'to_folder' => 'tmp/attachments/' . $editId,
                          'create_to_folder' => true));
              return new Response("wtf ??!");
              
            }
        }

   $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));

   $formalbum=$this->createForm(new albumType(),new album()); 
   $formsong=$this->createForm(new songType(),new song());      
      

    return $this->render('soullifiedboardBundle:board:newBoard.html.twig',
                            array('posting'=>$posting,
                                  "id"=>$board->getId(),
                                  'editId'=>$editId,
                                  'isNew'=>$isNew,
                                  'cancel'=>"dsqdsq",
                                  'formalbum'=>$formalbum->createView(),
                                  'formsong'=>$formsong->createView(),
                                  'existingFiles'=>$existingFiles,
                                  'formboard'=>$formboard->createView(),
                                  )
                            );
       
    
     }

   public function showAction($url)
    {


       $formmessage=$this->createForm(new messageType(),new message());
       $formfriendrequest=$this->createForm(new friendrequestType(),new friendrequest());

       $request=$this->get('request');
       if (strpos($url,'Rusbinaprofil') !== false) {     
               return $this->redirect($this->generateUrl('pingsteprofil',array('id'=>str_replace("Rusbinaprofil","",$url))));       
       }

       $em = $this->getDoctrine()->getManager();
       $board=$em->getRepository('soullifiedboardBundle:board')->findOneBy(array('url' => $url));


       if(!$board)  return $this->render('soullifiedboardBundle:notfound:notfoundboard.html.twig');
       else if ($board->getIscommunity()==false) return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$url)));

       $posting=new album();
       $formalbum=$this->createForm(new albumType(),new album()); 
       $isNew=true;


       $security=$this->container->get('security.context');
       $token=$security->getToken();
       $user=$token->getUser();


     if($user=="anon.")
        $flag="anonymous";

     else if($user->getProfil()->getId()==$board->getProfil()->getId())
       $flag="Owner";

     else{

      $roleflagservice=$this->container->get('soullifiedprofil.roleflag');
      $flag=$roleflagservice->getFlag($this->container,$board->getProfil());
      
      }

      $formBoard=$this->createForm(new communityboardType(),$board);
      
      $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId))
        {
            $isNew=false;
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($posting->getId())
            {
                
                $this->get('punk_ave.file_uploader')->syncFiles(
                    array('from_folder' => 'attachments/' . $posting->getId(), 
                          'to_folder' => 'tmp/attachments/' . $editId,
                          'create_to_folder' => true));
              return new Response("wtf ??!");
              
            }
        }

       $existingFiles=null;

    /* security check */
          
       $liked=false;

       if($user!="anon."){
       foreach ($user->getProfil()->getBoardsliked() as $lboard) {
          if($lboard->getId()==$board->getId()) {
            $liked=true;
            break;
          }
       }
    
    }
   /* $this->get('session')->set('anonyname', "lol");
    return new Response($this->get('session')->get('anonyname'));
*/
      return $this->render('soullifiedboardBundle:communityboard:communityboard.html.twig',
                            array('posting'=>$posting,
                                  'editId'=>$editId,
                                  'isNew'=>$isNew,
                                  'cancel'=>"dsqdsq",
                                  'existingFiles'=>$existingFiles,
                                  'formalbum'=>$formalbum->createView(),
                                  'formboard'=>$formBoard->createView(),
                                  'board'=>$board,
                                  'liked'=>$liked,
                                  'formmessage'=>$formmessage->createView(),
                                  'formfriendrequest'=>$formfriendrequest->createView(),
                                  'roleflag'=>$flag,
                                  )
                            );
    }



    public function editAction($boardId){


         $request = $this->getRequest();
         $editId =  $this->getRequest()->get('editId');
         $em = $this->getDoctrine()->getManager();
         $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    

    /* security check */
          
         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
        if($user->getProfil()->getId()!=$board->getProfil()->getId()) return new Response("fail o93éd!!");
    /* end security check */


         $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
         $i=-1;
         $formalbum = $this->createForm(new albumType(),new album());

    if($request->getMethod()=='POST')
            {
                        $formalbum->submit($request);
               if ($formalbum->isValid()) {
                        $albumdata=$formalbum->getData();
                        $albumdata->setDate(date('Y-m-d'));
                        $albumdata->setBoard($board);
                        $albumdata->setFolder($editId);
                        $em->persist($albumdata);
    
                       foreach ($existingFiles as $photoname) {
                          $photo= new photo();
                          $photo->setTitle($photoname);
                          $photo->setUrl($photoname);
                          $photo->setDescription("lool");
                          $photo->setDate(date('Y-m-d'));
                          $photo->setAlbum($albumdata);
                          $em->persist($photo);
                       }                       

                        $em->flush();
                        return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$board->getUrl())));

                  }
            }
               return new Response("fail uploading the album !!"); 



                   }



}