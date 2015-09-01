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

class boardController extends Controller
{
  public function addnewboardAction(){
    $request = $this->getRequest();
    $type=$request->get("type");
    $em = $this->getDoctrine()->getManager();      
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $profil=$user->getProfil();
    $board=new board();
    $bboard = new board();
    $board->setprofil($profil);
     if($type=="wall")  $board->setIscommunity(true);
     else $board->setIscommunity(false);
    $em->persist($board);
    $em->flush();
    $formboard=$this->createForm(new boardType(),new board());
    return $this->render('soullifiedboardBundle:board:newBoard.html.twig',
                            array(
                                  "id"=>$board->getId(),
                                  'formboard'=>$formboard->createView(),
                                  'type'=>$type,
                                  )
                            );
       
    
   }


   public function notFoundAction()
   {
      return $this->render('soullifiedboardBundle:notfound:notfoundboard.html.twig');     
   }

   public function showAction($url)
    {
      if($url == "googlef9b6c6eb722544a9.html")
        return new response("google-site-verification: googlef9b6c6eb722544a9.html"); 

      if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedHttpException('Dude u cant go there');//replace the fucking 
         }
       $request=$this->get('request');
       if (strpos($url,'Rusbinaprofil') !== false) {     
          return $this->redirect($this->generateUrl('pingsteprofil',array('id'=>str_replace("Rusbinaprofil","",$url))));       
       }

       $em = $this->getDoctrine()->getManager();
       $board=$em->getRepository('soullifiedboardBundle:board')->findOneBy(array('url' => $url));

       if(!$board)  return $this->render('soullifiedboardBundle:notfound:notfoundboard.html.twig');

       else if ($board->getIscommunity()==true) return $this->redirect($this->generateUrl('ruspeena_community_board_show',array('url'=>$url)));

       $posting=new album();
       $formalbum=$this->createForm(new albumType(),new album()); 
       $isNew=true;
       $security=$this->container->get('security.context');
       $token=$security->getToken();
       $user=$token->getUser();

     if($user->getProfil()->getId()==$board->getProfil()->getId())
       $flag="Owner";

     else{

      $roleflagservice=$this->container->get('soullifiedprofil.roleflag');
      $flag=$roleflagservice->getFlag($this->container,$board->getProfil());
      
      if(($board->getViewPrivacy()=="owner")) 
          {
            throw new AccessDeniedHttpException('Dude u cant go there');
            }

      if(($flag!="friend")&&($flag!="Owner")&&($board->getViewPrivacy()=="friends")) 
          {
            throw new AccessDeniedHttpException('Dude u cant go there');
            }
      }

      $formfriendrequest=$this->createForm(new friendrequestType(),new friendrequest());
      $formmessage=$this->createForm(new messageType(),new message());
      $formBoard=$this->createForm(new boardType(),$board);
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
       foreach ($user->getProfil()->getBoardsliked() as $lboard) {
          if($lboard->getId()==$board->getId()) {
            $liked=true;
            break;
          }
       }
      return $this->render('soullifiedboardBundle:board:board.html.twig',
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
         $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';
         rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
         rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
         rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
         rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");
         rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");
         $i=-1;
         $formphoto = $this->createForm(new photoType(),new photo());

    if($request->getMethod()=='POST')
            {
                        $formphoto->submit($request);
               if ($formphoto->isValid()) {
                        
                       foreach ($existingFiles as $photoname) {
                          $photo= new photo();
                          $photo=$formphoto->getData();
                          $photo->setFolder($editId);
                          $photo->setBoard($board);
                          $photo->setUrl("1");
                          $photo->setDate(date('Y-m-d'));
                          $em->persist($photo);
                       }                       
                        $em->flush();
                        return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$board->getUrl())));
                  }
            }
      return new Response("fail uploading the album !!"); 
     }

    public function deleteAction(){
      $editId = $this->getRequest()->get('editId'); 
      $this->get('punk_ave.file_uploader')->removeFiles(array('folder' => 'attachments/' .$editId));
      return new Response($editId);
    }


    public function uploadAction()
        {
            $editId = $this->getRequest()->get('editId');

            
            if (!preg_match('/^\d+$/', $editId))
            {
                throw new Exception("Bad edit id");
            }
            $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
        }

    public function updatePosAlbumAction(){

      $request=$this->get('request');
      $em = $this->getDoctrine()->getManager();
      $id=$request->get('album');
      $folder=$request->get('folder');
      $top=$request->get('top');
      $left=$request->get('left');
      if(!is_numeric($top) || !is_numeric($left))
        return false;
      $em = $this->getDoctrine()->getManager();
      //check if it is an integer
      if($id)
        $album =$em->getRepository("soullifiedboardBundle:photo")->find($id);
      else
        $album =$em->getRepository("soullifiedboardBundle:photo")->findOneBy(array('folder' => $folder));

      if($album==NULL){
        $return=array("responseCode"=>200,"resultat"=>"failed to find ressource ");
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));
      }

      $album->setPosx($left);
      $album->setPosy($top);

      $em->persist($album);
      $em->flush();


    $return=array("responseCode"=>200,"resultat"=>$top);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    }


    public function updateRotateAlbumAction($albumId){

      $request=$this->get('request');
      $em = $this->getDoctrine()->getManager();
      $deg=$request->request->get('deg');
      $em = $this->getDoctrine()->getManager();
      $album =$em->getRepository("soullifiedboardBundle:photo")->find($albumId);
      $album->setRotation($deg);
      $em->persist($album);
      $em->flush();
      $return=array("responseCode"=>200,"resultat"=>$deg);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
   
   }



    public function setPredefinedBackgroundAction($boardId){
        $request = $this->getRequest();
        $predefinedId =  $this->getRequest()->get('predefinedId');
        $em = $this->getDoctrine()->getManager();
        $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId); 
        $board->setCoverurl($predefinedId);
        $em->persist($board);
        $em->flush();
        $return=array("responseCode"=>200,"resultat"=>$predefinedId);
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function setUploadedBackgroundAction()
    {
        $request = $this->getRequest();
        $editId =  $this->getRequest()->get('editId');
        $boardId =  $this->getRequest()->get('boardId');


        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
        $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';
        rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
        rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
        rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
        rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");
        rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");

        $em = $this->getDoctrine()->getManager();
        $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
        $board->setCoverurl("/web/uploads/tmp/attachments/".$editId."/large/"."1");
        $em->persist($board);
        $em->flush();
       



        $return=array("responseCode"=>200,"resultat"=>$editId);
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json')); 
    }

    public function editbackgroundAction(){

         $request = $this->getRequest();
         $boardId = $request->get("boardId");
         $editId = $request->get('editId');
         $em = $this->getDoctrine()->getManager();
         $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);    
         $predefinedbackgroud =  $request->request->get('predefinedbackgroud');

         $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
         $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';
         
         // $url=$editId."/originals/".$existingFiles[0];

        if($predefinedbackgroud=="" && $existingFiles){
 
         rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
         rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
         rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");
         rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
         rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");

         // return new Response( __DIR__.'/../../../web/uploads/tmp/attachments/'.$url);
         
        }
        
    /* security check */
        
         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
        if($user->getProfil()->getId()!=$board->getProfil()->getId()) return new Response("fail !!");
    /* end security check */



  /* missing the remove action */

         if($predefinedbackgroud=="" && $existingFiles)  $board->setCoverurl("/web/uploads/tmp/attachments/".$editId."/large/"."1");
         else if($predefinedbackgroud !="") $board->setCoverurl($predefinedbackgroud);
         $em->persist($board);
         $em->flush();

         $return=array("responseCode"=>200,"resultat"=>$boardId);
         $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));


    }

    public function remove_backgroundcoverAction($boardId){
        
     $em = $this->getDoctrine()->getManager();
     $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    /* security check */            
     $security=$this->container->get('security.context');
     $token=$security->getToken();
     $user=$token->getUser();
     if($user->getProfil()->getId()!=$board->getProfil()->getId())
      return new Response("fail !!");
    /* end security check */
     $board->setCoverurl(NULL);
     $em->persist($board);
     $em->flush();
     return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$board->getUrl())));
    }

   public function remove_songAction($boardId){
        
         $em = $this->getDoctrine()->getManager();
         $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
         // $board->resetplaylist();
         $songs=$board->getSongs();

         foreach ($songs as $song) {
           $em->remove($song);
           $song=NULL;
         }
         $em->flush();
         return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$board->getUrl())));
    }

    public function changeViewPrivacyAction($boardId){

         $em = $this->getDoctrine()->getManager();
         $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
         $privacy=$this->getRequest()->get('privacy');       

    /* security check */

         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
        if($user->getProfil()->getId()!=$board->getProfil()->getId()) return new Response("fail !!");
    /* end security check */

         $board->setViewprivacy($privacy);
         $em->persist($board);
         $em->flush();
 

        $return=array("responseCode"=>200,"resultat"=>"sucess");
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));
        

 }

   public function changeCommentPrivacyAction($boardId){

         $em = $this->getDoctrine()->getManager();
         $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
         $privacy=$this->getRequest()->get('privacy');       

    /* security check */

         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
        if($user->getProfil()->getId()!=$board->getProfil()->getId()) return new Response("fail !!");
    /* end security check */

         $board->setCommentprivacy($privacy);
         $em->persist($board);
         $em->flush();
 

        $return=array("responseCode"=>200,"resultat"=>"sucess");
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));
        

 }

 public function compressboardAction(){
         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
         $profil=$user->getProfil();
         $request = $this->getRequest();
         $compress= $request->get('compress');
         if($compress=="true") $compressparam=true;
         else $compressparam=false; 
         $profil->setMenuboardcompressed($compressparam);
         $em = $this->getDoctrine()->getManager();
         $em->persist($profil);
         $em->flush(); 
         $return=array("responseCode"=>200,"resultat"=>$compressparam);
         $return=json_encode($return);
         return new Response($return,200,array('Content-Type'=>'application/json'));
  
 }

public function remove_albumAction($albumId){

         $em = $this->getDoctrine()->getManager();
         $album=$em->getRepository('soullifiedboardBundle:photo')->find($albumId);

         $request = $this->getRequest();
         $em = $this->getDoctrine()->getManager();      
         $security=$this->container->get('security.context');
         $token=$security->getToken();
         $user=$token->getUser();
         $profil=$user->getProfil();
        



        if($profil->getPhotourl() && $album->getId()==$profil->getPhotourl()->getId()) 
          $profil->setPhotourl(null);
       $em->remove($album);   
       $em->flush();
      $return=array("responseCode"=>200,"resultat"=>"sucess");
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));  
 }

public function likeBoardAction(){
  $request = $this->getRequest();
  $boardId = $this->getRequest()->get('boardId');
  $em = $this->getDoctrine()->getManager();
  $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
  $board->incrementpopularity();
  $security=$this->container->get('security.context');
  $token=$security->getToken();
  $user=$token->getUser();
  $profil=$user->getProfil();
  $profil->addBoardsliked($board);
  //TODO if already a fan  check
  $em->persist($profil);
  $em->persist($board);
  $em->flush();          
  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}


public function unlikeBoardAction(){
  $request = $this->getRequest();
  $boardId = $this->getRequest()->get('boardId');
  $em = $this->getDoctrine()->getManager();
  $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
  $board->incrementpopularity();
  $security=$this->container->get('security.context');
  $token=$security->getToken();
  $user=$token->getUser();
  $profil=$user->getProfil();
  $profil->removeBoardsliked($board);
  //TODO if already a fan  check
  $em->persist($profil);
  $em->persist($board);
  $em->flush();          
  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}

public function saveNewBoardAction($boardId){
    $request = $this->getRequest();
    $em = $this->getDoctrine()->getManager();       
    $editId =  $request->request->get('editId');
    $predefinedbackgroud =  $request->request->get('predefinedbackgroud');
    $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
    $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';         
    if($existingFiles ){
         rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
         rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
         rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");
         rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
         rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");
    }
  /* missing the remove action */
    $formboard=$this->createForm(new boardType(),$board);
    $boardUrl="";
    $formboard->submit($request);
    $boarddata=$formboard->getData();              
    $boarddata->setPopularity(0) ;
    $boarddata->setContainer($request->request->get('container'));
    $boarddata->setIsprofil(0);
    $boarddata->setDate(date("F j, Y H:i:s"));
    if($existingFiles ) 
      //return new response($editId."/large/"."1");
      $boarddata->setCoverurl("/web/uploads/tmp/attachments/".$editId."/large/"."1");
    else 
      $boarddata->setCoverurl($predefinedbackgroud);
    
    $bboard = new board();
    while ($bboard) {  
          $boardUrl = sprintf('%09d', mt_rand(0, 1999999999));
          $bboard=$em->getRepository('soullifiedboardBundle:board')->findOneBy(array('url' => $boardUrl));
    }              
    $boarddata->setUrl($boardUrl);
    $boarddata->setCommentprivacy("public");
    $em->persist($boarddata);
    $em->flush();
    $rediurl=$boarddata->getUrl();
    return $this->redirect("/life/#/board/$rediurl");                              
}


  public function myboardsAction(){
    return $this->render('soullifiedboardBundle:myboards:myboards.html.twig');
  }

 public function myboardsModalAction($profilId){
    $request = $this->getRequest();
    $em = $this->getDoctrine()->getManager();      
    $profil=$em->getRepository('soullifiedprofilBundle:profil')->find($profilId);  
    return $this->render('soullifiedboardBundle:myboards:myboardsmodal.html.twig',
                          array('profil'=>$profil));
  }



 public function editboardAction($boardId){
    $request = $this->getRequest();
    $em = $this->getDoctrine()->getManager();      
    $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    $formboard=$this->createForm(new boardType(),$board);
    
    if($request->getMethod()=='POST')
            {
              $formboard->submit($request);
              $boarddata=$formboard->getData();              
              $em->persist($boarddata);
              $em->flush();
              return $this->redirect($this->generateUrl('soullifiedprofil_showboard',array('url'=>$boarddata->getUrl())));                              
            }

  }

  public function uploadscreenAction($boardId){
 
    $dataURL = $this->getRequest()->get('file');
    // Extract base64 data
    // we have an unneeded header, zap it
    $parts1= explode(';', $dataURL);
    $parts = explode(',', $parts1[1]);
    $lol=  $parts[1];
    $data = $lol;  
    // Decode
    $data = base64_decode($data);  
    // Save
    $fp = fopen('web/uploads/tmp/screens/'.$boardId.'.jpg', 'w');  
    fwrite($fp, $data);  
    fclose($fp);   
 

    $request = $this->getRequest();
    $em = $this->getDoctrine()->getManager();
    $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    $board->setPreview(true);
    $em->persist($board);
    $em->flush();

    $return=array("responseCode"=>200,"resultat"=>"sucess");
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }

  public function setpinnedAction($boardId){

   $request = $this->getRequest();
   $em = $this->getDoctrine()->getManager();      
   $security=$this->container->get('security.context');
   $token=$security->getToken();
   $user=$token->getUser();
   $profil=$user->getProfil();

   $em = $this->getDoctrine()->getManager();
   $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
  
   if($board->getProfil()->getId()!=$user->getProfil()->getId())
      return new response("permission denied !!");
  
  $board->setPinned(true);
  $em->persist($board);
  $em->flush();

  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}

public function setunpinnedAction($boardId){
  $request = $this->getRequest();
  $em = $this->getDoctrine()->getManager();      
  $security=$this->container->get('security.context');
  $token=$security->getToken();
  $user=$token->getUser();
  $profil=$user->getProfil();

  $em = $this->getDoctrine()->getManager();
  $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
  
  if($board->getProfil()->getId()!=$user->getProfil()->getId())
    return new response("permission denied !!");
  
  $board->setPinned(false);
  $em->persist($board);
  $em->flush();

  $return=array("responseCode"=>200,"resultat"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}


public function bindBoardSongAction(){
  $request = $this->getRequest();
  $boardId = $this->getRequest()->get('boardId');
  $trackId = $this->getRequest()->get('trackId');
  $em = $this->getDoctrine()->getManager();
  $board = $em->getRepository('soullifiedboardBundle:board')->find($boardId);
  $track= $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($trackId);
  $board->setTrack($track);
  $em->persist($board);
  $em->flush();
  $return=array("responseCode"=>200,"boardId"=>$board->getUrl());
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}


public function validateFilterAction()
{
  $boardId = $this->getRequest()->get('boardId');
  $filterId = $this->getRequest()->get('filterId');
  $em = $this->getDoctrine()->getManager();
  $board = $em->getRepository('soullifiedboardBundle:board')->find($boardId);
  $board->setFilter($filterId);
  $em->persist($board);
  $em->flush();
  $return=array("responseCode"=>200,"boardId"=>"sucess");
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}

}
