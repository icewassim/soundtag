<?php

namespace soullified\profilBundle\profilboardgenerator;

use soullified\boardBundle\Entity\board;
use soullified\boardBundle\Entity\comment;


class lifelistboardgenerator{

    public function generate($em,$profil){

    $bboard=1;
      while ($bboard) {  
        $editId = sprintf('%09d', mt_rand(0, 1999999999));
        $bboard=$em->getRepository('soullifiedboardBundle:board')->findOneBy(array('url' => $editId));
      }

      $board= new board();
      $board->setUrl($editId);
      $board->setTitle($profil->getFullname()." 's Life List");
      $board->setCoverurl("\/pictures\/background\/paper1.jpg");
      $board->setIsProfil(false);
      $board->setViewprivacy("owner");
      $board->setCommentprivacy("owner");
      $board->setDescription("This is the list of things i want to achieve in my life");
      $board->setProfil($profil);
      $profil->setLifelistboard($board);
      $em->persist($board);
      $em->flush();
   }
}