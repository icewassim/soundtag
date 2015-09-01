<?php

namespace soullified\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use soullified\profilBundle\Entity\profil;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
   public function registerAction(Request $request)
   {

    if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) 
           return new RedirectResponse($this->container->get('router')->generate('render_home_page'));
    
      $response = parent::registerAction($request);
      $user = $this->container->get('security.context')->getToken()->getUser();
      $em =  $this->container->get("Doctrine")->getManager();
      $nom=$request->request->get('displayname');

      $bio=$request->request->get('bio');
      
      if($request->request->get('hiddennconfirm'))
      {
          $profile=new Profil();
          $profile->setUser($user);
          if($nom=="")
            $nom=$user->getUsername();
          $profile->setFullname($nom);
          $profile->setAbout($bio);
          $profile->setAbouttrigger(false);
          $profile->setProfilphototrigger(false);

          $user->setprofil($profile);
          $em->persist($user);
          $em->flush();

          $boardgenerator=$this->container->get('soullifiedprofil.profilboardgenerator');
          $board=$boardgenerator->getFlag($em,$profile);
          $profile->setProfilboard($board);
          $em->persist($profile);
          $em->persist($board);
          $em->flush();
       }       
        // ... do custom stuff
        return $response;
    }

     /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
      $response = parent::confirmedAction();
      $url = $this->container->get('router')->generate('profil_fresh_avatar');
      $response = new RedirectResponse($url);       
      return $response;

    }
}