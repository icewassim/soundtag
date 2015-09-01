<?php 
namespace soullified\UserBundle\Controller;

use soullified\UserBundle\Form\UserType;
use soullified\UserBundle\Entity\User;

use soullified\profilBundle\Entity\profil;
use soullified\profilBundle\Form\profilType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
	public function loginAction()
	{
		// Si le visiteur est déjà identifié, on le redirige vers l'accueil
		if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
		   	 // return new Response($user->getId());
			// return $this->redirect($this->generateUrl('fos_user_security_login'));
        	 return $this->redirect($this->generateUrl('render_home_page'));
        	// return new Response("hello");
		}

/*			 $security=$this->container->get('security.context');
         	 $token=$security->getToken();
        	 $user=$token->getUser();
     if($user=="anon."){
		return $this->redirect($this->generateUrl('show_home_page'));
     }*/


		 // $security=$this->container->get('security.context');
   //       $token=$security->getToken();
   //       $user=$token->getUser();

   //      if($user)
			//  return $this->redirect($this->generateUrl('show_home_page'));

		$request = $this->getRequest();
		$session = $request->getSession();

	    $session->set("name","wassim");
		// On vérifie s'il y a des erreurs d'une précédente soumissiondu formulaire
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} 
		else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		$em = $this->getDoctrine()->getManager();		
		$erreur='';
		


		$formprofil =$this->createForm(new profilType(),new profil());
        $formuser=$this->createForm(new UserType(),new user());

	    $popular=$em->getRepository("soullifiedboardBundle:board")->findBy(array("viewprivacy"=>"public","isprofil"=>0),array('popularity' =>'desc'),5,0);
	    $recent=$em->getRepository("soullifiedboardBundle:board")->findBy(array("viewprivacy"=>"public","isprofil"=>0),array('id' =>'desc'),5,0);


		
		return $this->render('soullifiedprofilBundle:Default:index.html.twig',
		array(
		// Valeur du précédent nom d'utilisateur entré parl'internaute
		'last_username' => $session->get(SecurityContext::LAST_USERNAME),
		'popular'=>$popular,
        'recent'=>$recent,
		'formuser'=>$formuser->createView(),
        'error'=>$error,
        'formprofil' =>$formprofil->createView()));
	}


    /**
     * @Route("/login_check", name="_login_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_demo_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }


	public function adduserAction(){

			$formuser =$this->createForm(new UserType(),new User);
			$request=$this->get('request');
			if($request->getMethod()=='POST')
				{
					$formuser->salt=NUll;	
					$formuser->submit($request);				
					$enregistrement=$formuser->getData();		
					
					$em = $this->getDoctrine()->getManager();
					$em->persist($enregistrement);
					$em->flush();
			
/*
					//return $this->redirect('confirm');
					//----------------------------------------------------------------------------------------
					    $message = \Swift_Message::newInstance('ssssss','text is going here');
					//	$message = new Message();
						$message->setTo(array('wassimbenameur90@gmail.com'))
    							->setFrom('wassimbenameur@gmail.com');
					//----------------------------------------------------------------------------------------

	*/


					return new Response ("inscription reussi !");
			}
		}


public function verifEmailAction(){
		
		$request=$this->get('request');
		$em = $this->getDoctrine()->getManager();

		$resultat="notfound";
	
		$email=$this->getRequest()->get('email');
		$liste_emails =$em->getRepository('soullifiedUserBundle:User')->findBy(array('email' =>$email));
	
		if($liste_emails) $resultat="found";
	
		$return=array("responseCode"=>200,"resultat"=>$resultat);
		$return=json_encode($return);

		return new Response($return,200,array('Content-Type'=>'application/json'));
}
	
	
public function verifUsernameAction(){
		
		$request=$this->get('request');
		$em = $this->getDoctrine()->getManager();

		$resultat="notfound";
	
		$username=$this->getRequest()->get('username');
		$liste_usernames =$em->getRepository('soullifiedUserBundle:User')->findBy(array('username' =>$username));
	
		if($liste_usernames) $resultat="found";
	
		$return=array("responseCode"=>200,"resultat"=>$resultat);
		$return=json_encode($return);

		return new Response($return,200,array('Content-Type'=>'application/json'));
}
	


}