<?php

namespace soullified\lifesoundtrackBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use soullified\lifesoundtrackBundle\Entity\track;
use soullified\lifesoundtrackBundle\Entity\songtrack;
use soullified\lifesoundtrackBundle\Entity\commentphoto;
use soullified\lifesoundtrackBundle\Entity\commenttrack;
use soullified\profilBundle\Entity\profil;
use soullified\UserBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class lifesoundtrackController extends Controller
{
    public function showHomePageAction($username)
    {
	    $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $user = $em->getRepository('soullifiedUserBundle:user')->findOneBy(array('username' => $username));
      $profil = $user->getProfil();
      return $this->render('soullifiedlifesoundtrackBundle:Default:lifesoundtrack.html.twig',
      						array('profil' => $profil ));
    }

    public function getSoundtrackAngularAction()
    {
        $nickName = $this->getRequest()->get('nickName');
        $idx = $this->getRequest()->get('idx');
        $em = $this->getDoctrine()->getManager();
        if($nickName)
        {
          $user  = $em->getRepository('soullifiedUserBundle:user')->findOneBy(array('username' => $nickName));
        }

        $trackArray=array();
        $tracks = $em->getRepository('soullifiedlifesoundtrackBundle:track')->findBy(array('profil' =>$user->getProfil()->getId()),array('id' => 'desc'),5,$idx);
        foreach ($tracks as $track) {
          $commentsArray=array();
          foreach ($track->getCommentstrack() as $comment) {
            array_push($commentsArray, array(
                                        "id"=>$comment->getId(),
                                        "content"=>$comment->getContent(),
                                        "ownerFullname"=>$comment->getOwner()->getFullname(),
                                        "ownerProfilPicture"=>$comment->getOwner()->getProfilPicture(),
                                        "ownerNickname"=>$comment->getOwner()->getId()
                                      ));
           }

          $commentsArray = array_reverse($commentsArray);
          $photosArray=array();
          foreach ($track->getPhotos() as $photo) {
            array_push($photosArray, array(
                                        "src"=>$photo->getUrl(),
                                        "id"=>$photo->getId(),
                                        "editId"=>$photo->getEditid(),
                                      ));
           }
           if($track->getSongtrack())
          array_push($trackArray,array(
                                  "songTitle"=>$track->getSongtrack()->getTitle(),
                                  "title"=>$track->getSongtitle(),
                                  "id"=>$track->getId(),
                                  "songtrackId"=>$track->getSongtrack()->getId(),
                                  "youtubeId"=>$track->getSongtrack()->getYoutubeid(),
                                  "lyrics"=>$track->getChosenlyrics(),
                                  "date"=>$track->getDate(),
                                  "mood"=>$track->getMood(),
                                  "ready" => ($track->getSongtrack()->getIsready())?"ready":"not-ready",
                                  "profilFullname"=>($track->getSender())?$track->getSender()->getFullname():null,
                                  "profilPictureSrc"=>($track->getSender())?$track->getSender()->getProfilPicture():null,
                                  "comments"=>$commentsArray,
                                  "photos"=>$photosArray,
                                  ));
        }

        $boardsArray = array();
        foreach ($user->getProfil()->getBoards() as $userBoard) {
          if($userBoard->getUrl() && $userBoard->getIsprofil() ==  false)
            array_push($boardsArray,array("id"=>$userBoard->getId(),
                                          "name"=>$userBoard->getTitle(),
                                          "url"=>$userBoard->getUrl(),
                                            ));
        }
        
        $return=array("responseCode" =>200,
                      "trackArray"=> $trackArray,
                      "boardsArray" => $boardsArray,
                      "user"=> array( 'nickName'  => $user->getId(),
                                      'fullName' => $user->getProfil()->getFullname(),
                                      'roleFlag' => "owner",
                                      'background' => $user->getProfil()->getTrackbackground(),
                                      'profilPic' => $user->getProfil()->getProfilPictureBig(),
                                      'aboutMe'=>$user->getProfil()->getAbout()
                                      )
                      );
     


        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json')); 
      }

    public function showHomePageAngularAction()
    {
      return $this->render('soullifiedlifesoundtrackBundle:Default:lifesoundtrackangular.html.twig');
    }

    public function getLyricsAction()
    {


    $return=array("responseCode"=>200,"finalId"=>$finalId);
    $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));

    $findme = strpos($fileContent, "http://www.chartlyrics.com/app/correct.aspx?lid");
		$findmetrue= strpos(substr($fileContent,$findme),' ');
		$final_lyrics=substr(substr($fileContent,$findme),$findmetrue);
    $return=array("responseCode"=>200,"artist"=>$artistName,"songTitle"=>$songTitle,"lyrics"=>$final_lyrics);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    function addSongAction()
    {
      $security=$this->container->get('security.context');
      $token=$security->getToken();
      $user=$token->getUser();
      $profil=$user->getProfil();
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $boardId = $request->request->get('boardId');
      $songTitle= $request->request->get('title');
      $songArtist = $request->request->get('artist');
      $chosenlyrics =$request->request->get('lyrics');
      $songPic =$request->request->get('songPic');
      $mood = $request->get('newTrackId');
      $freshTrack= $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($mood);  
      if($boardId ==  -1)
        $board = $profil->getProfilboard();
      else
        $board  = $em->getRepository('soullifiedboardBundle:board')->find($boardId);
      $owner = $board->getprofil();
      if($freshTrack)
        $track=$freshTrack;
      else
        $track= new track();
      $track->setSongtitle($songTitle." - ".$songArtist);
      $track->setDate(date("Y\-m\-d H:i:s"));
      $track->setSender($profil);
      $track->setProfil($owner);
      $track->setMood($mood);
      $track->setChosenlyrics($chosenlyrics);
      $board->setTrack($track);
      $em->persist($track);
      $em->persist($board);
      $em->flush();
      $testTrack= $em->getRepository('soullifiedlifesoundtrackBundle:songtrack')->findOneBy(array('mainTitle' =>$songTitle." - ".$songArtist));
      if($testTrack)
        $track->setSongtrack($testTrack);
      else
          {
            $songTrack = new songtrack();
            $songTrack->setArtist($songArtist);
            $songTrack->setTitle($songTitle);
            //todo check what s the second null request
            if($songPic)
              $songTrack->setSongPic($songPic);
            $songTrack->setMainTitle($songTitle." - ".$songArtist);
            $track->setSongtrack($songTrack);
            $em->persist($songTrack);
           }
      $em->persist($track);
      $em->flush();
      $return=array("responseCode"=>200,
                    "songId"=>$track->getId(),
                    "songPic"=>$songPic,
                    "songTitle" =>$track->getSongtitle(),
                    "songtrackId"=>$track->getSongtrack()->getId(),
                    "boardId"=>$boardId,
                    "youtubeId"=>$track->getSongtrack()->getYoutubeid());
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function getFullLyricsAction()
    {
      $request = $this->get('request');
      $id = $request->get('id');
      if($id != -1)
      {
        $em = $this->getDoctrine()->getManager(); 
        $track = $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($id);
        $tempArray= explode("-",$track->getSongtitle());
        $artistName=trim($tempArray[1]);
        $songTitle = trim($tempArray[0]);
      }
      else
        $songTitle = $request->get("songTitle");
        $artistName = $request->get("artistName");

      $fileContent = file_get_contents("http://api.chartlyrics.com/apiv1.asmx/SearchLyricDirect?artist=".urlencode($artistName)."&song=".urlencode($songTitle));
      $findme = strpos($fileContent, "http://www.chartlyrics.com/app/correct.aspx?lid");
      $findmetrue= strpos(substr($fileContent,$findme),' ');
      $final_lyrics=substr(substr($fileContent,$findme),$findmetrue);
      
//      $final_lyrics="See the stone set in your eyes See the thorn twist in your side. I wait for you. Sleight of hand and twist of fate On a bed of nails she makes me wait And I wait without you With or without you With or without you. Through the storm, we reach the shore You gave it all but I want more And I'm waiting for you With or without you With or without you. I can't live with or without you. And you give yourself away And you give yourself away And you give, and you give And you give yourself away. My hands are tied, my body bruised She got me with nothing to win And nothing else to lose. And you give yourself away And you give yourself away And you give, and you give And you give yourself away. With or without you With or without you I can't live With or without you. With or without you With or without you I can't live With or without you With or without you.";
      $return=array("responseCode"=>200,"artist"=>$artistName,"songTitle"=>$songTitle,"lyrics"=>$final_lyrics);
      

//      $return=array("responseCode"=>200,"artist"=>$artistName,"songTitle"=>$songTitle,"lyrics"=>"I can't remember anything\nCan't tell if this is true or dream\nDeep down inside I feel to scream\nThis terrible silence stops me \n Now that the war ...I can't remember anything\nCan't tell if this is true or dream\nDeep down inside I feel to scream \nThis terrible silence stops me \nNo");
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function updateLyricsAction()
    {
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $id= $request->request->get('id');
      $chosenlyrics= $request->request->get('chosenlyrics');
      $track = $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($id);
      $track->setChosenlyrics($chosenlyrics);
      $em->persist($track);
      $em->flush();

      $return=array("responseCode"=>200);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function getNextWaveAction()
    {
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $idx= $request->get('idx');
      $id= $request->get('id');

      $tracks = $em->getRepository('soullifiedlifesoundtrackBundle:track')->findBy(array('profil' =>$id),array('id' => 'desc'),5,$idx);
      $finalTab = array();
      foreach ($tracks as $track) {
      array_push($finalTab,array(
                              "title"=>$track->getSongtitle(),
                              "id"=>$track->getId(),
                              "songtrackId"=>$track->getSongtrack()->getId(),
                              "youtubeId"=>$track->getSongtrack()->getYoutubeid(),
                              "lyrics"=>$track->getChosenlyrics(),
                              "date"=>$track->getDate(),
                              "mood"=>$track->getMood(),
                              "ready" => ($track->getSongtrack()->getIsready())?"ready":"not-ready",
                              "profilFullname"=>$track->getProfil()->getFullname(),
                              "profilPictureSrc"=>$track->getProfil()->getProfilPicture(),
                              ));
      }
     
      $return=array("responseCode"=>200,"taille"=>sizeof($finalTab),"finalTab"=>$finalTab,"idx"=>$idx);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function generateEditIdAction()
    {
      $editId = sprintf('%09d', mt_rand(0, 1999999999));     
      $return=array("responseCode"=>200,"editId"=>$editId);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }
    
    public function addCommentAction()
    {
      $security = $this->container->get('security.context');
      if (!$security->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            throw new AccessDeniedHttpException('Dude u cant go there');

      $token = $security->getToken();
      $user = $token->getUser();
      $profil = $user->getProfil();
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $trackId = $request->get('trackId');
      $editId = $request->get('editId');
              
      $track = $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($trackId);
      $content = $request->request->get('content');
      $comment = new commenttrack();
      $comment->setOwner($profil);
      $comment->setTrack($track);
      $comment->setContent($content);
      $comment->setDate(date("Y\-m\-d H:i:s"));
      $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
      $em->persist($comment);
      $em->flush();
      $return=array("responseCode"=>200,"id"=>$comment->getId());
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }
    public function deleteCommentAction()
    {
      $security = $this->container->get('security.context');
      if (!$security->isGranted('IS_AUTHENTICATED_REMEMBERED'))

            throw new AccessDeniedHttpException('Dude u cant go there');
 
      $token = $security->getToken();
      $user = $token->getUser();
      $profil = $user->getProfil();
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $commentId = $request->get('commentId');
      $comment = $em->getRepository('soullifiedlifesoundtrackBundle:commenttrack')->find($commentId);
      if($profil->getId()==$comment->getOwner()->getId())
      {
        $em->remove($comment);
        $em->flush();
      }
      $return=array("responseCode"=>200,"ok"=>"ok");
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
              
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

    public function getFullLyricsReadyAction()
    {
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $trackId= $request->get('trackId');
      $track = $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($trackId);
      $songTrack = $track->getSongtrack();
      $fullLyrics = $songTrack->getFulllyrics();
      $return=array("responseCode"=>200,"lyrics"=>$fullLyrics);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json')); 
    }

    public function updateFullLyricsAction()
    {
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $fullLyrics= $request->request->get('FullLyrics');
      $trackId= $request->request->get('trackId');
      $track = $em->getRepository('soullifiedlifesoundtrackBundle:track')->find($trackId);
      $songTrack = $track->getSongtrack();
      $songTrack->setFulllyrics($fullLyrics);
      $em->persist($songTrack);
      $em->flush();

      $return=array("responseCode"=>200,"ok"=>$fullLyrics);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function updateYoutubeIdAction()
    {
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager(); 
      $songtrackId= $request->get('songtrackId');
      $vidId= $request->get('videoId');
      $songtrack= $em->getRepository('soullifiedlifesoundtrackBundle:songtrack')->find($songtrackId);
      $songtrack->setYoutubeid($vidId);
      $em->persist($songtrack);
      $em->flush();
      $return=array("responseCode"=>200,"ok"=>$vidId);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function setLifesoundtrackPredefinedBackgroundAction(){
        $predefinedId =  $this->getRequest()->get('predefinedId');
        $security=$this->container->get('security.context');
        $token=$security->getToken();
        $user=$token->getUser();
        $profil=$user->getProfil();
        $profil->setTrackbackground($predefinedId);
        $em = $this->getDoctrine()->getManager(); 
        $em->persist($profil);
        $em->flush();
        $return=array("responseCode"=>200,"resultat"=>$predefinedId);
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));
    }

public function saveTrackBackgroundAction(){
   $request = $this->getRequest();
   $editId =  $this->getRequest()->get('editId');
   $trackId =  $this->getRequest()->get('trackId');
   $em = $this->getDoctrine()->getManager();
   $track=$em->getRepository('soullifiedlifesoundtrackBundle:track')->find($trackId);
   /* security check */
   $security=$this->container->get('security.context');
   $token=$security->getToken();
   $user=$token->getUser();
   /* end security check */
   $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
   $story = $request->get('story');
    if($story!= "")
      $track->setChosenlyrics($story);
   if($editId)
     {
      foreach ($existingFiles as $photoname) 
      {
        $photo= new commentphoto();
        $photo->setUrl($photoname);
        $photo->setEditid($editId);
        $track->addPhoto($photo);
        $photo->setTrack($track);
        $em->persist($photo);
      }                       
     }
    $em->persist($track);
    $em->flush();


    $return=array("responseCode"=>200,"id"=>$story);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
   }
}
