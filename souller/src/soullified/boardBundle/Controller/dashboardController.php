<?php

namespace soullified\boardBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use soullified\boardBundle\Entity\dashboard;
use Symfony\Component\Filesystem\Filesystem;
use soullified\boardBundle\Entity\board;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class dashboardController extends Controller
{
  public function showDashboardAction()
  {
     return $this->render('soullifiedboardBundle:dashboard:dashboardTemplate.html.twig');
  }

  public function showDashboardTemplateAction()
  {
    $em = $this->getDoctrine()->getManager();
    $wave=$this->getRequest()->get('wave');
    $popular=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('popularity' =>'desc'),20,$wave);
    $boardsArray = array();
    foreach ($popular as $board) {
    if($board->getUrl())
      array_push($boardsArray,array('boardId' =>$board->getId(),
                                    'title' =>$board->getTitle(),
                                    'desc' =>$board->getDescription(),
                                    "coverurl"=>($board->getPreviewpic()==NULL?str_replace("large","small",$board->getCoverurl()):$board->getPreviewpic()),
                                    'likes'=>sizeof($board->getLikers()),
                                    'boardurl'=>$board->getUrl(),
                                    'ownerPic'=>$board->getProfil()->getProfilPicture(),
                                    'date'=>$board->getDate(),
                                    'ownerName'=>$board->getProfil()->getFullname(),
                                    'comments'=>sizeof($board->getComments()),
                                     ));
    }
    $return=array("responseCode"=>200,"popular"=>$boardsArray);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }

  public function showDashboardRecentTemplateAction()
  {

    $em = $this->getDoctrine()->getManager();
    $recent=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('id' =>'desc'),40,0);
    $boardsArray = array();
    foreach ($recent as $board) {
    if($board->getUrl())
      array_push($boardsArray,array('boardId' =>$board->getId(),
                                    'title' =>$board->getTitle(),
                                    'desc' =>$board->getDescription(),
                                    'ownerPic'=>$board->getProfil()->getProfilPicture(),
                                    'ownerName'=>$board->getProfil()->getFullname(),
                                    'date'=>$board->getDate(),
                                    "coverurl"=>($board->getPreviewpic()==NULL?str_replace("large","small",$board->getCoverurl()):$board->getPreviewpic()),
                                    'likes'=>sizeof($board->getLikers()),
                                    'boardurl'=>$board->getUrl(),
                                    'comments'=>sizeof($board->getComments()),
                                     ));
    }

    $return=array("responseCode"=>200,"popular"=>$boardsArray);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }

  public function showDashboardLikedTemplateAction()
  {
    $security = $this->container->get('security.context');
    $token = $security->getToken();
    $user = $token->getUser();
    $recent=$user->getProfil()->getBoardsliked();
    $boardsArray = array();
    foreach ($recent as $board) {
    if($board->getUrl())
      array_push($boardsArray,array('boardId' =>$board->getId(),
                                    'title' =>$board->getTitle(),
                                    'desc' =>$board->getDescription(),
                                    'ownerPic'=>$board->getProfil()->getProfilPicture(),
                                    'ownerName'=>$board->getProfil()->getFullname(),
                                    'date'=>$board->getDate(),
                                    "coverurl"=>($board->getPreviewpic()==NULL?str_replace("large","small",$board->getCoverurl()):$board->getPreviewpic()),
                                    'likes'=>sizeof($board->getLikers()),
                                    'boardurl'=>$board->getUrl(),
                                    'comments'=>sizeof($board->getComments()),
                                     ));
    }

    $return=array("responseCode"=>200,"popular"=>$boardsArray);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }


  public function showDashboardMyBoardsTemplateAction()
  {
    $em = $this->getDoctrine()->getManager();
    $security = $this->container->get('security.context');
    $token = $security->getToken();
    $user = $token->getUser();
    $recent=$user->getProfil()->getBoards();
    $boardsArray = array();
    foreach ($recent as $board) {
      if($board->getUrl())
        array_push($boardsArray,array('boardId' =>$board->getId(),
                                    'title' =>$board->getTitle(),
                                    'pinned'=>$board->getPinned(),
                                    'desc' =>$board->getDescription(),
                                    'date'=>$board->getDate(),
                                    "coverurl"=>($board->getPreviewpic()==NULL?str_replace("large","small",$board->getCoverurl()):$board->getPreviewpic()),
                                    "isProfil"=>$board->getisprofil(),
                                    'boardurl'=>$board->getUrl(),
                                    'likes'=>sizeof($board->getLikers()),
                                    'comments'=>sizeof($board->getComments()),
                                     ));
    }

    $return=array("responseCode"=>200,"popular"=>$boardsArray);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }

  public function getDashElementsAction()
  {
    $request = $this->getRequest();
    $security = $this->container->get('security.context');
    $token = $security->getToken();
    $user = $token->getUser();
    $dashboard = $user->getProfil()->getDashboard();
    $firstTime=false;
    if(!$dashboard)
    {
      $dashboard= new dashboard();
      $dashboard->setLifesoundtrack(true);
      $dashboard->setAvatar(true);
      $dashboard->setAbout(true);
      $dashboard->setTodolist(false);
      $user->getProfil()->setDashboard($dashboard);
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      $firstTime=true;
    }
    $isTodo = $dashboard->getTodolist();
    $lifesoundtrack = $dashboard->getLifesoundtrack();
    $avatar = $dashboard->getAvatar();
    $about = $dashboard->getAbout();
    $dashelement = array('about' =>$about ,
                         'avatar'=>$avatar,
                         'lifesoundtrack'=>$lifesoundtrack,
                         'isTodo'=>$isTodo,
                         'firstTime'=>$firstTime
                          );

    $return=array("responseCode"=>200,"dashelement"=>$dashelement);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }


  public function selectElementAction()
  {
    $request = $this->getRequest();
    $security = $this->container->get('security.context');
    $token = $security->getToken();
    $user = $token->getUser();
    $dashboard = $user->getProfil()->getDashboard();
    $dashObj = $this->getRequest()->get('dashObj');
    if($this->getRequest()->get('selected')=="true")
      $select=true;
    else
      $select=false;
    switch ($dashObj) {
      case 'dashObj1':
        $dashboard->setLifesoundtrack($select);
        break;
      case 'dashObj2':
        $dashboard->setAbout($select);
        break;
      case 'dashObj3':
        $dashboard->setTodolist($select);
      break;
      case 'dashObj4':
        $dashboard->setAvatar($select);
      break;
    }
    $em = $this->getDoctrine()->getManager();
    $em->persist($dashboard);
    $em->flush();
    $return=array("responseCode"=>200,"dashelement"=>$select);
    $return=json_encode($return);
    return new Response($return,200,array('Content-Type'=>'application/json'));
  }
}