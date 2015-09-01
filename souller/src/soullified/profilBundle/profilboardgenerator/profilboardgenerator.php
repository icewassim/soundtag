<?php

namespace soullified\profilBundle\profilboardgenerator;

use soullified\boardBundle\Entity\board;
use soullified\boardBundle\Entity\comment;


class profilboardgenerator{

    public function getFlag($em,$profil){
 

      $board= new board();
      $boardtoclone=$em->getRepository("soullifiedboardBundle:board")->find(2);
      
      $board->setUrl("Rusbinaprofil".$profil->getUser()->getUsername());
      $board->setTitle("Life according to ".$profil->getUser()->getUsername());
      $board->setIsProfil(true);
      $board->setViewprivacy("public");
      $board->setCommentprivacy("owner");
      $board->setProfil($profil);
      
      foreach ($boardtoclone->getComments() as $comment) {
        $newcomment= new comment();
        $newcomment->setContent($comment->getContent());
        $newcomment->setBoard($board);
        $newcomment->setDate("");
        $newcomment->setFont($comment->getFont());
        $newcomment->setPosy($comment->getPosy());
        $newcomment->setPosx($comment->getPosx());
        $newcomment->setSize($comment->getSize());
        $newcomment->setColor($comment->getColor());
        $newcomment->setRotation($comment->getRotation());
        $newcomment->setOwner($profil);
              
        $board->addComment($newcomment);
        $em->persist($newcomment);
      }

      return $board;
       

       }




}