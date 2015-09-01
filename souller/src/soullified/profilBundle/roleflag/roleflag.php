<?php

namespace soullified\profilBundle\roleflag;

class roleflag{

    public function getFlag($container,$profil_to_check){
 

      $security=$container->get('security.context');
      $token=$security->getToken();
      $user=$token->getUser();
      $roleflag="";
       // check the add friend flag 

      if (!$user) return "public";
      else {
        $profil=$user->getProfil();
        if ($profil==$profil_to_check) return "Owner";
        else {
                foreach ($profil_to_check->getFriendrequests() as $FRequest) {     //should be replaced with one single sql request           
                    if ($profil->getId()==$FRequest->getSender()->getId()) $roleflag="friendseeker";

                }
              //very consuming code slow 
               foreach ($profil->getFriendship() as $friendship) {                
                    if ($friendship->getSecondfriend()->getId()==$profil_to_check->getId()) $roleflag="friend";
                }

                    if(($roleflag!="friendseeker")&&($roleflag!="friend")) $roleflag="notafriend";
              }

     }

     return $roleflag;
       

       }




}