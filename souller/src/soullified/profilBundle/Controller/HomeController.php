<?php

namespace soullified\profilBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use soullified\profilBundle\Entity\profil;
use soullified\UserBundle\Entity\User;
use soullified\boardBundle\Entity\photo;
use soullified\boardBundle\Entity\board;

class HomeController extends Controller
{



  public function avatarChosenAction()
  {
    $em = $this->getDoctrine()->getManager();
    $request=$this->get('request');
    $avatar = $request->request->get('avatar');
    $newusername = $request->request->get('username');
    $security=$this->container->get('security.context');
    $token=$security->getToken();
    $user=$token->getUser();
    $liste_usernames =$em->getRepository('soullifiedUserBundle:User')->findBy(array('username' =>$newusername));
    if(strlen($newusername) > 0 && !$liste_usernames)
    {
      $user->setUsername($newusername);
      $user->getProfil()->getProfilboard()->setTitle("life according to ".$newusername);
    }

    $profil=$user->getProfil();
    $photo =  new Photo();
    $photo->setUrl($avatar);
    $photo->setFolder("avatar");
    $photo->setDate(date('Y-m-d'));
    $profil->setPhotourl($photo);
    $em->persist($photo);
    $em->persist($profil);
    $em->persist($user);
    $em->flush();

    $url = $this->container->get('router')->generate('render_home_page');
    $response = new RedirectResponse($url);       
    return $response;
  }

  public function chooseAvatarAction()
  {
    $em = $this->getDoctrine()->getManager();
    $popular=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('popularity' =>'desc'),30,0);
    $recent=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('id' =>'desc'),5,0);
    
    return $this->render('soullifiedprofilBundle:home:chooseAvatar.html.twig',
                          array('popular'=>$popular,
                              'recent'=>$recent,
                                      )); 
  }

  public function chooseFreshAvatarAction()
  {
    $em = $this->getDoctrine()->getManager();
    $popular=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('popularity' =>'desc'),30,0);
    $recent=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('id' =>'desc'),5,0);
    
    return $this->render('soullifiedprofilBundle:home:freshAvatar.html.twig'); 
  }


   public function showAction(){
      $security=$this->container->get('security.context');
      if($security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $token=$security->getToken();
                $connectedUser=$token->getUser();
                if((strpos($connectedUser->getUsername(),'facebook') !== false) || (strpos($connectedUser->getUsername(),'google') !== false) ||
                 strlen($connectedUser->getUsername())==0)
                      return $this->render('soullifiedprofilBundle:home:freshAvatar.html.twig'
                                      ); 
      }
      else
        return "not connected";

    $em = $this->getDoctrine()->getManager();
    $popular=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('popularity' =>'desc'),30,0);
    $recent=$em->getRepository("soullifiedboardBundle:board")->findBy(array("isprofil"=>0),array('id' =>'desc'),5,0);
    
    return $this->render('soullifiedprofilBundle:home:home.html.twig',
                          array('popular'=>$popular,
                              'recent'=>$recent,
                                      ));
   
   }
}