<?php
namespace soullified\UserBundle\Security\Core\User;
 
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManager as BaseUserManager;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Security\Core\User\UserInterface;
use soullified\profilBundle\Entity\profil;
use soullified\boardBundle\Entity\board;
use soullified\boardBundle\Entity\comment;
 
class FOSUBUserProvider extends BaseClass
{
 
    /**
     *
     * @var EntityManager 
     */

    protected $em;
    protected $userManager;

        /**
     * @var array
     */
    protected $properties;

    public function __construct( BaseUserManager $usermanager, array $properties ,EntityManager $entityManager)
    {
            $this->em = $entityManager;
            $this->userManager= $usermanager;
            $this->properties  = $properties;
        }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
 
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
 
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
 
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
 
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
 
        $this->userManager->updateUser($user);
    }
 
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $property = $this->getProperty($response);


        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($property => $username));

        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            // $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($property.$username);
            $user->setEmail($response->getEmail());
            $user->setPassword($response->getAccessToken());
            $user->setEnabled(true);
            
            if($property=="google_id") $user->setGoogleId($username);
            else if($property=="facebook_id") $user->setFacebook_id($username);

            $profile=new Profil();
            $profile->setFullname($response->getRealName());
            $profile->setPhotoconnect($response->getProfilePicture());
            // $profile->setAbout();
            $profile->setAbouttrigger(false);
            $profile->setProfilphototrigger(false);
            $user->setprofil($profile);


            $this->userManager->updateUser($user);
            
            $em=$this->em;

            // $request=$this->get('request');

            $board= new board();
            $boardtoclone=$em->getRepository("soullifiedboardBundle:board")->find(2);
          
            $board->setUrl("Rusbinaprofil".$username);
            $board->setTitle("Life according to ".$username);
            $board->setIsProfil(true);
            $board->setViewprivacy("public");
            $board->setCommentprivacy("owner");
            $board->setProfil($profile);
          
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
                $newcomment->setOwner($profile);         
                $board->addComment($newcomment);
                $em->persist($newcomment);
            }


            //------------------------------------------------
            $profile->setProfilboard($board);
            $em->persist($profile);
            $em->persist($board);
            $em->flush();
            $connectedUser = parent::loadUserByOAuthUserResponse($response);
            return $connectedUser;
        }//end if user  is registarting 
 
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
 
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
 
        //update access token
        $user->$setter($response->getAccessToken());
 
        return $user;
    }
 
}