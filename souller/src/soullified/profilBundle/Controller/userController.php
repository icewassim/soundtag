<?php

namespace soullified\profilBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use soullified\profilBundle\Entity\profil;
use soullified\profilBundle\Form\profilType;
use soullified\UserBundle\Entity\User;
use soullified\UserBundle\Form\UserType;
use soullified\boardBundle\Form\boardType;


use soullified\boardBundle\Entity\board;
use soullified\profilBundle\Entity\feedback;

use soullified\boardBundle\Entity\comment;
use soullified\boardBundle\Form\songType;

use soullified\profilBundle\Entity\friendrequest;
use soullified\profilBundle\Form\friendrequestType;

use soullified\profilBundle\Entity\message;
use soullified\profilBundle\Form\messageType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use soullified\boardBundle\Entity\photo;
use soullified\boardBundle\Form\photoType;
use soullified\boardBundle\Entity\song;


class userController extends Controller
{
    public function addAction($id)

    { 
           $userManager = $this->get('fos_user.user_manager');
           $user= $userManager->findUserBy(array('id' =>$id));

           $em = $this->getDoctrine()->getManager();
           $profil=new Profil();
           $user->setprofil($profil);
                      
           $em->persist($user);
           $em->flush();
           $request=$this->get('request');
           $boardgenerator=$this->container->get('soullifiedprofil.profilboardgenerator');
           $board=$boardgenerator->getFlag($em,$profil);
           $profil->setProfilboard($board);
           $em->persist($profil);
           $em->persist($board);
           $em->flush();

          // $url = $this->container->get('router')->generate('fos_user_registration_confirmed',array('id'=>$user->getId()));  
          // $response = new RedirectResponse($url);
          // // return $this->redirect($this->generateUrl('pingsteprofil',array('id'=>$profil->getId())));
          // $dispatcher = $this->container->get('event_dispatcher');

          // $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request,$response));

          // return $response;

  }



      public function registerAction()

    { 
         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
           // $userManager = $this->get('fos_user.user_manager');
           // $user= $userManager->findUserBy(array('id' =>$id));

           $em = $this->getDoctrine()->getManager();
           $profil=new Profil();
           $user->setprofil($profil);
                      
           $em->persist($user);
           $em->flush();
           $request=$this->get('request');
           $boardgenerator=$this->container->get('soullifiedprofil.profilboardgenerator');
           $board=$boardgenerator->getFlag($em,$profil);
           $profil->setProfilboard($board);
           $em->persist($profil);
           $em->persist($board);
           $em->flush();

          return new Response("wtf ????????");
          // $url = $this->container->get('router')->generate('fos_user_registration_confirmed',array('id'=>$user->getId()));  
          // $response = new RedirectResponse($url);
          // // return $this->redirect($this->generateUrl('pingsteprofil',array('id'=>$profil->getId())));
          // $dispatcher = $this->container->get('event_dispatcher');

          // $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request,$response));

          // return $response;

  }


    public function saveAction(){

    	//$profil= new profil();

    }
    
    public function updatePosBoardAction($boardId){

      $request=$this->get('request');
      $em = $this->getDoctrine()->getManager();

      $top=$request->get('top');
      $left=$request->get('left');
      $em = $this->getDoctrine()->getManager();
      $halfboard =$em->getRepository("soullifiedboardBundle:board")->find($boardId);

      $halfboard->setPosleft($left);
      $halfboard->setPostop($top);

      $em->persist($halfboard);
      $em->flush();

      $return=array("responseCode"=>200,"resultat"=>$top);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));

    }
  


    public function showprofilAction(){
      $request=$this->get('request');
      $posting=new photo(); 
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

       return $this->render('soullifiedprofilBundle:user:profilpage.html.twig',
                            array(
                                  'posting'=>$posting,
                                  'editId'=>$editId,
                                  'cancel'=>"dsqdsq",
                                  )
                            );


    }





   public function showprofilTemplateAction(){
       return $this->render('soullifiedprofilBundle:user:profilTemplate.html.twig');
    }



public function editprofilphotoAction(){
        $request = $this->getRequest();
        $editId = $request->get('editId');
        /* security check */
         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
        /* end security check */
         $em = $this->getDoctrine()->getManager();
         $profil = $user->getProfil();
         $board=$profil->getProfilboard();

         $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
         $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';
         rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
         rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
         rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
         rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");
         rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");

      foreach ($existingFiles as $photoname) {
         $photo= new photo();
         $photo->setFolder($editId);
         //$photo->setBoard($board);
         $photo->setUrl("1");
         $photo->setDate(date('Y-m-d'));
         $profil->setPhotourl($photo);
         $em->persist($photo);
        }                       
       $em->flush();
       return new response("sucess");
}


public function resetabouttriggerAction(){

      $security=$this->container->get('security.context');     
      $token=$security->getToken();
      $user=$token->getUser();
      $profile=$user->getProfil();
      $profile->setAbouttrigger(true);
      $em = $this->getDoctrine()->getManager();
      $em->persist($profile);
      $em->flush();

      $return=array("responseCode"=>200,"resultat"=>"sucess");
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));


}


public function resetphototriggerAction(){
  $security=$this->container->get('security.context');
  $token=$security->getToken();
  $user=$token->getUser();
  $profile=$user->getProfil();      
  $profile->setProfilphototrigger(true);
  $em = $this->getDoctrine()->getManage();
  $em->persist($profile);
  $em->flush();
  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}
 
public function setFavFontAction()
{
  $profilId = $this->getRequest()->get('profilId');
  $favFont = $this->getRequest()->get('favFont');
  $em = $this->getDoctrine()->getManager();
  $profil=$em->getRepository('soullifiedprofilBundle:profil')->find($profilId);
  $profil->setFavfont($favFont);
  $em->persist($profil);
  $em->flush();
  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}

public function setFavColorAction()
{
  $profilId = $this->getRequest()->get('profilId');
  $favColor = $this->getRequest()->get('favColor');
  $em = $this->getDoctrine()->getManager();
  $profil=$em->getRepository('soullifiedprofilBundle:profil')->find($profilId);
  $profil->setFavColor($favColor);
  $em->persist($profil);
  $em->flush();
  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}


  public function showAngularClassicProfilAction()
  {
    return $this->render('soullifiedprofilBundle:user:profilClassiscTemplate.html.twig');
  }


  public function setWallPredefinedBackgroundAction(){
        $predefinedId =  $this->getRequest()->get('predefinedId');
        $security=$this->container->get('security.context');
        $token=$security->getToken();
        $user=$token->getUser();
        $profil=$user->getProfil();
        $profil->setWallbackground($predefinedId);
        $em = $this->getDoctrine()->getManager(); 
        $em->persist($profil);
        $em->flush();
        $return=array("responseCode"=>200,"resultat"=>$predefinedId);
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));
  }
  public function feedbackAction()
  {
    return $this->render('soullifiedprofilBundle:user:feedback.html.twig');
  }
  public function sendFeedbackAction()
  {
    $request=$this->get('request');
    $em =$this->getDoctrine()->getManager();
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $profil=NULL;
    $feedback =  new feedback();
    $contenu = $request->request->get("contenu");
    if($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
              $user=$token->getUser();
              $profil=$user->getProfil();  
              $feedback->setContenu($user->getId().' | '.$contenu);
         }
    else
	$feedback->setContenu(' | '.$contenu);
    $em->persist($feedback);
    $em->flush();
    $return=array("responseCode"=>200,"resultat"=>"success");
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }
    public function showAboutAction()
  { 
    return $this->render('soullifiedprofilBundle:Default:about.html.twig');
  }
}