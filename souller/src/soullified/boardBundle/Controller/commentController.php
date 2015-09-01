<?php
namespace soullified\boardBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\boardBundle\Entity\comment;
use soullified\boardBundle\Entity\album;
use soullified\profilBundle\Entity\event;
use soullified\boardBundle\Entity\upvotes;
use soullified\boardBundle\Form\albumType;
use soullified\boardBundle\Form\boardType;

use soullified\boardBundle\Entity\photo;
use soullified\boardBundle\Entity\host;
use soullified\boardBundle\Entity\board;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class commentController extends Controller
{
  public function addcommentAction($id){
    $request=$this->get('request');
    $em =$this->getDoctrine()->getManager();
    $board=$em->getRepository('soullifiedboardBundle:board')->find($id);
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $comment=new comment();
    $profil=NULL;

    if($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
              $user=$token->getUser();
              $profil=$user->getProfil();  
              $comment->setOwner($profil);
         }
    else{
        $name = $request->request->get("hostName");
        $email = $request->request->get("hostEmail");
        $hostVatar= $request->request->get("hostVatar");
        $host = new host();
        $host->setFullname($name);
        $host->setEmail($email);
        $host->setAvatar($hostVatar);
        $host->setIpadress($_SERVER['REMOTE_ADDR']);
        $comment->setHost($host);
        $em->persist($host);
    }
    $oldnbr=$board->getPopularity();
    $oldnbr=$oldnbr+1;
    $board->setPopularity($oldnbr);
    $font= $request->request->get('font');
    $size = $request->request->get('size');
    $color=$request->request->get('color');
    $content=$request->request->get('content');
    $allowedContent=$request->request->get('allowedContent');
    $desc=$request->request->get('desc');
    $rotation=$request->request->get('rotation');
    $posx=$request->request->get('posx');
    $posy=$request->request->get('posy');

    if($posy > $board->getMaxheigth())
      $board->setMaxheigth($posy);
    
    $velcro =$request->request->get('velcro');
    $photo=NULL;
    if($velcro)
      {
        $editId=$velcro;
        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
        $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';
        rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
        rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
        rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
        rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");
        rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");
        $photo = new Photo();
        $photo->setTitle($content);
        $photo->setDescription($desc);
        $photo->setFolder($velcro);
        $photo->setBoard($board);
        $photo->setPosy($posy);
        $photo->setPosx($posx);
        $photo->setUrl("1");
        $photo->setDate(date("Y\-m\-d H:i:s"));
        $em->persist($photo);
      }
    elseif($content){
      if($profil && $profil->getId()!=$board->getProfil()->getId()){
            $event= new event();
            $event->setDate(date("Y\-m\-d H:i:s"));
            $event->setSender($profil);
            $event->setReceiver($board->getProfil());
            $event->setType("comment");
            $event->setContent($content);
            $board->incrementpopularity();  
            $em->persist($board);  
            $em->persist($event);
            $nbr=$board->getProfil()->getUnseenevents();
            $nbr++;
            $board->getProfil()->setUnseenevents($nbr);
            $em->persist($board->getProfil());                     
      }
      $comment->comment($color,$content,$allowedContent,$desc,$rotation,$size,$posy,$posx,$font,date("Y\-m\-d H:i:s"));
      $comment->setVotes(0);
      $comment->setBoard($board);
      $em->persist($comment);
      $em->persist($board);
    }
    else 
      $return=array("responseCode"=>200,"commentId"=>"empty");
    
    $em->flush();
    if($photo)
      $return=array("responseCode"=>200,"photoId"=>$photo->getId(),"velcro"=>$posx);
    else
      $return=array("responseCode"=>200,"commentId"=>$comment->getId(),"velcro"=>$posx);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
 }

public function updatePosCommentAction($id){

      /*Never trust user's input*/

      $request=$this->get('request');
      
      $em = $this->getDoctrine()->getManager();

      $top=$request->get('top');
      $left=$request->get('left');

      if($top == "auto" && $left == "auto")
        return false;

      //check if it is an integer
      if(!is_numeric($top) || !is_numeric($left))
        return false;

      $em = $this->getDoctrine()->getManager();
      $comment =$em->getRepository("soullifiedboardBundle:comment")->find($id);
      $comment->setPosx($left);
      $comment->setPosy($top);
      $security=$this->container->get('security.context');
      $token=$security->getToken();
      $user=$token->getUser();
      if($comment->getBoard()->getProfil()->getId() == $user->getProfil()->getId() || $comment->getOwner()->getId() == $user->getProfil()->getId())
         {
            $em->persist($comment);
            $em->flush();
          }

    $return=array("responseCode"=>200,"resultat"=>$top." ".$left);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
    }



  public function remove_commentAction($commentId){      
    $em = $this->getDoctrine()->getManager();
    $comment=$em->getRepository('soullifiedboardBundle:comment')->find($commentId);
    $board=$comment->getBoard();
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    if($board->getProfil()->getId() == $user->getProfil()->getId() || $comment->getOwner()->getId() == $user->getProfil()->getId())
         {
          $board->decrementpopularity();
          $em->remove($comment);
          $em->persist($board);
          $em->flush();
         }
    $return=array("responseCode"=>200,"commentId"=>$comment->getId());
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }

public function removeBackgroundAction()
{
  $request=$this->get('request');
  $em = $this->getDoctrine()->getManager();
  $boardId=$request->get('boardId');
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
  $return=array("responseCode"=>200);
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}


public function updateBoardInfoAction()
{
    $request = $this->get('request');
    $em = $this->getDoctrine()->getManager();
    $boardId = $request->get('boardId');
    $newCommentPrivacy = $request->get('newCommentPrivacy');
    $newViewPrivacy = $request->get('newViewPrivacy');
    $newTitle = $request->get('newTitle');
    $newDescription = $request->get('newDescription');
    $board =$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    $newUrl = $request->get('newUrl');
    $newMaxLetters = $request->get('maxLetters');

    if($newTitle) 
      $board->setTitle($newTitle);
    if($newCommentPrivacy) 
      $board->setCommentprivacy($newCommentPrivacy);
    if($newViewPrivacy) 
      $board->setViewprivacy($newViewPrivacy);
    //todo convert to url
    if($newUrl) 
      $board->setUrl($newUrl);
    if($newDescription) 
      $board->setDescription($newDescription);
    if($newMaxLetters) 
      $board->setMaxLetters($newMaxLetters);
    $em->persist($board);
    $em->flush();
    
    $return=array("responseCode"=>200,"boardId"=>$boardId,"newViewPrivacy"=>$newViewPrivacy,"newCommentPrivacy"=>$newDescription);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
}

public function update_rotcommentAction($commentId){

      $request=$this->get('request');
      $em = $this->getDoctrine()->getManager();
      $deg=$request->request->get('deg');
      $em = $this->getDoctrine()->getManager();
      $comment =$em->getRepository("soullifiedboardBundle:comment")->find($commentId);
      $comment->setRotation($deg);
      $em->persist($comment);
      $em->flush();
      $return=array("responseCode"=>200,"resultat"=>$deg);
      $return=json_encode($return);
      return new Response($return,200,array('Content-Type'=>'application/json'));
  }

public function getAngularCommentsAction()
{
  $security=$this->container->get('security.context');
  $remoteIpAdress;
  if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $token=$security->getToken();
            $connectedUser=$token->getUser();
            $connectedProfil=$connectedUser->getProfil();            
   }else{
        $remoteIpAdress = $_SERVER['REMOTE_ADDR'];
        $connectedProfil = NULL;
   }

  $nickName = $this->getRequest()->get('nickName');
  $boardId = $this->getRequest()->get('boardId');
  $lifelist = $this->getRequest()->get('lifelist');
  $em = $this->getDoctrine()->getManager();
  if($nickName)
  {
    $user  = $em->getRepository('soullifiedUserBundle:user')->findOneBy(array('username' => $nickName));
    $board = $user->getProfil()->getProfilboard();
    //$boardTitle = "Life according to ".$user->getProfil()->getFullname()."|";
    $boardTitle = $board->getTitle();
  }
  elseif ($lifelist) {
    $user  = $em->getRepository('soullifiedUserBundle:user')->findOneBy(array('username' => $lifelist));
    $board = $user->getProfil()->getLifelistboard();
    if($board->getTitle() != "My Life List ")
      $boardTitle = $board->getTitle();
    else
      $boardTitle = $user->getProfil()->getFullname()."'s life list |";
  }
  elseif($boardId)
  {
    $board=$em->getRepository('soullifiedboardBundle:board')->findOneBy(array('url' => $boardId ));
    $boardTitle = $board->getTitle();
    $user=$board->getProfil()->getUser();
  }
  
  

  $upvotes=$em->getRepository('soullifiedboardBundle:upvotes')->findBy(array('owner' =>($connectedProfil != NULL)? $connectedProfil->getId():NULL,
                                                                             'boardid' => $board->getId()));
  $commentArray = array();
  //$comments=$em->getRepository('soullifiedboardBundle:comment')->findBy(array('board' => $board->getId()),array('votes' =>'desc'),50,0);
  $comments=$em->getRepository('soullifiedboardBundle:comment')->findBy(array('board' => $board->getId()));
  foreach ($comments as $comment) {
             array_push($commentArray,array(
                              "commentId"=>$comment->getId(),
                              "content"=>$comment->getContent(),
                              "allowedContent"=>$comment->getAllowedContent(),
                              "font"=>$comment->getFont(),
                              "commentDate"=>$comment->getDate(),
                              "votes"=>$comment->getVotes(),
                              "size"=>$comment->getSize(),
                              "rotation" =>$comment->getRotation(),
                              "color" =>$comment->getColor(),
                              "posx" =>$comment->getPosx(),
                              "nbrsubcomments" => $comment->getNbrsubcomments(),
                              "posy"=>$comment->getPosy(),
                              "ownerId"=>$comment->getOwner() && $comment->getOwner()->getUser() ?$comment->getOwner()->getUser()->getUsername():-1,
                              "ownerFullName"=>$comment->getOwner()?$comment->getOwner()->getFullname():$comment->getHost()->getFullname(),
                              "profilPic" =>$comment->getOwner()?$comment->getOwner()->getProfilPicture():$comment->getHost()->getAvatar(),
                              "desc" =>$comment->getlongtitle(),
                                ));
         }

    $boardsArray= array();
    //toDo replace the 170 loop
    if($board->getIsprofil())
    {
      foreach ($board->getProfil()->getBoards() as $userBoard ) {  
        if($userBoard->getTitle() && $userBoard->getUrl() &&
           $userBoard->getIsprofil()==false && $userBoard->getPinned() == true )
          array_push($boardsArray,array("id"=>$userBoard->getId(),
                                        "name"=>$userBoard->getTitle(),
                                        "posTop"=>$userBoard->getPostop(),
                                        "posLeft"=>$userBoard->getPosLeft(),
                                        "url"=>$userBoard->getUrl(),
                                        "title"=>$userBoard->getTitle(),
                                        "song"=>$userBoard->getTrack()?$userBoard->getTrack()->getSongtitle():NULL,
                                        "coverurl"=>($userBoard->getPreviewpic()==NULL?str_replace("large","small",$userBoard->getCoverurl()):$userBoard->getPreviewpic()),
                                        "nbrComments"=>sizeof($userBoard->getComments()),
                                        "nbrLikes"=>sizeof($userBoard->getLikers()),
                                          ));
        }
    }

  $trackArray=array();
  $tracksResult=$em->getRepository('soullifiedlifesoundtrackBundle:track')->findBy(array('profil' => $board->getProfil()->getId()),array('id' =>'desc'),5,0);
  foreach ($tracksResult as $track) {
    if($track->getSongtrack())
             array_push($trackArray,array(
                              "title"=>$track->getSongtitle(),
                              "songtrackId"=>$track->getSongtrack()->getId(),
                              "songPic"=>$track->getSongtrack()->getSongPic(),
                              "chosenLyrics"=>$track->getChosenlyrics(),
                              "youtubeId"=>$track->getSongtrack()->getYoutubeid(),
                                ));
  }

  $upvotesArray=array();
  foreach ($upvotes as $vote) {
             array_push($upvotesArray,array(
                              "commentId"=>$vote->getCommentid(),
                              "isUp"=>$vote->getIsUp(),
                                ));
         }

  $photosArray = array();
  foreach ($board->getPhotos() as $album) {
         array_push($photosArray,array(
                              "Id"=>$album->getId(),
                              "title"=>$album->getTitle(),
                              "Date"=>$album->getDate(),
                              "rotation" =>$album->getRotation(),
                              "posx" =>$album->getPosx(),
                              "posy"=>$album->getPosy(),
                              "folder"=>$album->getFolder(),
                              "url"=>$album->getUrl(),
                                ));
         }

  $boardtrack=array();
  if($board->getTrack())
  {
    $boardtrack = array("id"=>$board->getTrack()->getId(),
                        "title"=>$board->getTrack()->getSongtitle(),
                        "songtrackId"=>$board->getTrack()->getSongtrack()->getId(),
                        "chosenLyrics"=>$board->getTrack()->getChosenlyrics(),
                        "songPic"=>$board->getTrack()->getSongtrack()->getSongPic(),
                        "youtubeId"=>$board->getTrack()->getSongtrack()->getYoutubeid());
  }

  $liked=false;
  if($connectedProfil)
  {
    foreach ($connectedProfil->getBoardsliked() as $lboard) {
    if($lboard->getId() == $board->getId()) {
        $liked=true;
        break;
      }
    }
  }

  $nextBoardId = $em->getRepository('soullifiedboardBundle:board')->findBy(array('profil' =>$user->getProfil()->getId()
                                                                                 ,'isprofil'=>false),
                                                                           array('popularity' =>'desc'),10,0);

  $nextChain = array();
  foreach ($nextBoardId as $nextboard) {
    array_push($nextChain, $nextboard->getUrl());
  }

  
  $return=array("responseCode" =>200,
                "commentArray" =>$commentArray,
                "photosArray" => $photosArray,
                "nextBoardIds" => $nextChain,
                "trackArray"=> $trackArray,
                "upvotesArray" => $upvotesArray,
                "boardsArray"=>$boardsArray,
                "board"=> array('boardId' => $board->getId(),
                                'boardUrl' => $board->getUrl(),
                                'boardTitle' => $boardTitle ,
                                'maxLetters' => $board->getMaxLetters(),
                                'maxheigth' => $board->getMaxheigth(),
                                "nbrComments"=>sizeof($board->getComments()),
                                "nbrLikes"=>sizeof($board->getLikers()),
                                'boardDescription' => $board->getDescription(),
                                'boardCover'=> $board->getCoverurl(),
                                'viewPrivacy'=>$board->getViewprivacy(),
                                'commentPrivacy'=>$board->getCommentprivacy(),
                                'ownerId'=>$board->getProfil()->getId(),
                                'isProfil'=>$board->getIsProfil(),
                                'track' =>$boardtrack,
                                'filter'=>$board->getFilter(),
                                'liked'=>$liked,
                                ),

                "user"=> array( 'nickName'  => $user->getUsername(),
                                'fullName' => $user->getProfil()->getFullname(),
                                'favFont' =>($connectedProfil != NULL)?$connectedProfil->getFavfont():NULL,
                                'favColor' =>($connectedProfil != NULL)?$connectedProfil->getFavColor():NULL,
                                'profilPic' =>$user->getProfil()->getProfilPictureBig(),
                                'aboutMe' => $user->getProfil()->getAbout(),
                                'wallBackground' => $user->getProfil()->getWallbackground(),
                                'roleFlag' => "owner"
                                )
                );
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json')); 
}

  public function SubmitAngularPhotoAction()
  {
    $request = $this->get('request');
    $em = $this->getDoctrine()->getManager();
    $boardId = $request->get('boardId');
    $title = $request->get('title');
    $editId = $request->get('editId');
    $description = $request->get('description');
    $rotation=$request->get('rotation');
    $posx=$request->get('posx');
    $posy=$request->get('posy');
    $board=$em->getRepository('soullifiedboardBundle:board')->find($boardId);
    if(!is_numeric($posx) || !is_numeric($posy))
        return false;
    /* security check */
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    if($user->getProfil()->getId()!=$board->getProfil()->getId())
      return new Response("fail o93éd!!");
    /* end security check */
    $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
    $absolutPath=__DIR__.'/../../../../web/uploads/tmp/attachments/';
    rename($absolutPath.$editId."/originals/".$existingFiles[0],$absolutPath.$editId."/originals/"."1");
    rename($absolutPath.$editId."/small/".$existingFiles[0],$absolutPath.$editId."/small/"."1");
    rename($absolutPath.$editId."/large/".$existingFiles[0],$absolutPath.$editId."/large/"."1");
    rename($absolutPath.$editId."/thumbnails/".$existingFiles[0],$absolutPath.$editId."/thumbnails/"."1");
    rename($absolutPath.$editId."/medium/".$existingFiles[0],$absolutPath.$editId."/medium/"."1");
    $photo= new photo();
    $photo->setFolder($editId);
    $photo->setBoard($board);
    $photo->setUrl("1");
    $photo->setDate(date('Y-m-d'));
    $photo->setTitle($title);
    $photo->setDescription($description);
    $photo->setPosx($posx);
    $photo->setPosy($posy);
    $em->persist($photo);
    $em->flush();
    $return=array("responseCode"=>200,"photoId"=>$photo->getId());
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json')); 
  }
public function getAngularMyBoardsAction()
{
  $nickName = $this->getRequest()->get('nickName');
  if($this->getRequest()->get('scrollIndex'))
    $scrollIndex = $this->getRequest()->get('scrollIndex');
  else
    $scrollIndex=0;

  $em = $this->getDoctrine()->getManager();
  $return;
  $allowProfil=false;
  if($nickName)
  {
    //$myboards=$em->getRepository("soullifiedboardBundle:board")->findBy(array("profil"=>$user->getProfil()->getId())
    $user  = $em->getRepository('soullifiedUserBundle:user')->findOneBy(array('username' => $nickName));
    $myboards=$em->getRepository("soullifiedboardBundle:board")->findBy(array('profil' => $user->getProfil()->getId())
                                                                      ,array('popularity' =>'desc'),10,$scrollIndex*10);
    if(sizeof($myboards)==1)
      $myboards=$em->getRepository("soullifiedboardBundle:board")->findBy(array()
                                                                      ,array('popularity' =>'desc'),10,$scrollIndex*10);
  }
  else
    $myboards=$em->getRepository("soullifiedboardBundle:board")->findBy(array()
                                                                      ,array('popularity' =>'desc'),10,$scrollIndex*10);
    $boardsArray= array();
    foreach ($myboards as $userBoard) {
      if($userBoard->getTitle() && $userBoard->getUrl() && ($userBoard->getIsProfil() == false))
        array_push($boardsArray,array("id"=>$userBoard->getId(),
                                      "name"=>$userBoard->getTitle(),
                                      'ownerPic'=>$userBoard->getProfil()->getProfilPicture(),
                                      'date'=>$userBoard->getDate(),
                                      'ownerName'=>$userBoard->getProfil()->getFullname(),
                                      "url"=>$userBoard->getUrl(),
                                      "desc"=>$userBoard->getDescription(),
                                      "song"=>$userBoard->getTrack()?$userBoard->getTrack()->getSongtitle():NULL,
                                      "coverurl"=>($userBoard->getPreviewpic()==NULL?str_replace("large","small",$userBoard->getCoverurl()):$userBoard->getPreviewpic()),
                                      "nbrComments"=>sizeof($userBoard->getComments()),
                                      "nbrLikes"=>sizeof($userBoard->getLikers()),
                                        ));
    }
    $return=array("responseCode"=>200,"boards"=>$boardsArray);
  $return=json_encode($return);
  return new Response($return,200,array('Content-Type'=>'application/json'));
}

  public function upVoteAction()
  {
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
              $user=$token->getUser();
              $profil=$user->getProfil();  
              $request=$this->get('request');
              $em = $this->getDoctrine()->getManager();
              $commentId = $request->get('commentId');
              $isdownVoted = $request->get('downVoted');
              $comment =$em->getRepository("soullifiedboardBundle:comment")->find($commentId);
              $upvote = $em->getRepository("soullifiedboardBundle:upvotes")->findOneBy(array("commentid"=>$commentId,
                                                                                              "owner"=>$profil->getId()
                                                                                              ));
              if($upvote)
              {
               if($upvote->getIsUp()==true)
                  return new Response("wtf ?");
                else
                  $upvote->setIsUp(true);  
                  $comment->upvote();
              }
              else
              {
                $upvote =  new upvotes();
                $upvote->setCommentid($commentId);
                $upvote->setIsUp(true);
                $upvote->setBoardid($comment->getBoard()->getId());
                $upvote->setOwner($profil);
              }
             /* if($isdownVoted == true)
                $comment->upvote();
             */$comment->upvote();
              $em->persist($upvote);
              $em->persist($comment);
              $em->flush();
              $return=array("responseCode"=>200,"resultat"=>$commentId);
              $return=json_encode($return);
              return new Response($return,200,array('Content-Type'=>'application/json'));
    }
    else
      return new Response("fail");
  }

  public function downVoteAction()
  {
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
              $user=$token->getUser();
              $profil=$user->getProfil();  
              $request=$this->get('request');
              $em = $this->getDoctrine()->getManager();
              $commentId = $request->get('commentId');
              $isUpVoted = $request->get('upVoted');
              $comment =$em->getRepository("soullifiedboardBundle:comment")->find($commentId);
              $upvote = $em->getRepository("soullifiedboardBundle:upvotes")->findOneBy(array("commentid"=>$commentId,
                                                                                              "owner"=>$profil->getId()
                                                                                              ));
              if($upvote)
              {
               if($upvote->getIsUp()==false)
                  return new Response("wtf ?");
                else
                  $upvote->setIsUp(false);  
                  $comment->downvote();              
              }
              else
              {
                $upvote =  new upvotes();
                $upvote->setCommentid($commentId);
                $upvote->setIsUp(false);
                $upvote->setBoardid($comment->getBoard()->getId());
                $upvote->setOwner($profil);
              }
              $comment->downvote();
              $em->persist($upvote);
              $em->persist($comment);
              $em->flush();
              $return=array("responseCode"=>200,"resultat"=>$commentId);
              $return=json_encode($return);
              return new Response($return,200,array('Content-Type'=>'application/json'));
    }
    else
      return new Response("fail");
  }

  public function cancelVoteAction()
  {
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
        $user=$token->getUser();
        $profil=$user->getProfil();  
        $request=$this->get('request');
        $em = $this->getDoctrine()->getManager();
        $commentId = $request->get('commentId');
        $comment =$em->getRepository("soullifiedboardBundle:comment")->find($commentId);
        $upvote = $em->getRepository("soullifiedboardBundle:upvotes")->findOneBy(array("commentid"=>$commentId,
                                                                                              "owner"=>$profil->getId()
                                                                                              ));
        if($upvote->getIsUp() == false)
          $comment->upvote();
         else
          $comment->downvote();
        $em->persist($comment);
        $em->remove($upvote);
        $em->flush();
        $return=array("responseCode"=>200,"resultat"=>$commentId);
        $return=json_encode($return);
        return new Response($return,200,array('Content-Type'=>'application/json'));       
    }
  }
}