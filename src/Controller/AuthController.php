<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface as AuthEncoder;
use App\Entity\User;
use App\Entity\Role;
use App\Form\Type\AuthForm;
use App\Repository\UserRepository;

class AuthController extends AbstractController 
{
	public const INVALID_USER = 'User Already Exists';

	public function __construct(AuthEncoder $encoder, ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
	{
		$this->authEncoder = $encoder;
		$this->db = $doctrine->getManager();
    	$this->repo = $this->db->getRepository(User::class);
	}

	public function register(Request $request, ManagerRegistry $doctrine) 
	{
    	$user = new User;
    	$createForm = $this->createForm(AuthForm::class, $user);
    	$createForm->handleRequest($request);
    	$createForm->submit(json_decode($request->getContent(), true));
    	if($createForm->isSubmitted() && $createForm->isValid()) {
    		$user = $createForm->getData();
			$email = $user->getEmail();
			$registeredEmail = $this->repo->checkEmail($email);
			if ($registeredEmail == true) {
				return new Response(self::INVALID_USER, Response::HTTP_UNAUTHORIZED);	
			}
    		$entityManager = $doctrine->getManager();
    		$entityManager->persist($user);
    		$entityManager->flush($user);

    		return new Response(Response::HTTP_CREATED);
		}

		return false;
    }

	public function authenticate(Request $request) 
	{
    	$user = json_decode($request->getContent(), true);
    	$email = $user['email'];
		$password = $user['password'];
    	$response = $this->repo->authenticateUser($email, $password);
    	if($response == true) {
    		$authToken = $this->createToken($user);
    	}
		else {
    		return new Response(Response::HTTP_UNAUTHORIZED);
		} 

	}
  	public function createToken($user) {

    	return $this->authEncoder->encode(
    	[
    		'user_email' => $user['email'],
    		'user_role' => $user['role']
    	]);
    }
}
