<?php

namespace soullified\profilBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\FOSUserEvents as Event;


use soullified\profilBundle\Entity\message;
use soullified\profilBundle\Form\messageType;
use soullified\profilBundle\Entity\board;

use \HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class getuserinfoController extends Event
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response){

      var_dump(
          $response->getEmail(),
          $response->getProfilePicture()
      );
    
    }


}