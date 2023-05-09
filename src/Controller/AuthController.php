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
use App\Service\AuthService;

class AuthController extends BaseController
{
    public const USER_EXISTS = 'User Already Exists';

    /**
     * Method to register user.
     */
    public function register(Request $request)
    {
        $user = new User;
        $createForm = $this->createForm(AuthForm::class, $user);
        $user = $this->authService->getFormDetails($request, $createForm);
        $email = $user->getEmail();
        $password = $user->getPassword();
        $registeredEmail = $this->db->getRepository(User::class)->authenticate($email, $password);
        if ($registeredEmail == true) {
            return new Response(self::USER_EXISTS, Response::HTTP_UNAUTHORIZED);  
        }
        $this->dbInsert($user);

        return new Response(Response::HTTP_CREATED);
    }

    /**
     * Method to authenticate user.
     */
    public function authenticate(Request $request)
    {
        $user = json_decode($request->getContent(), true);
        $email = $user['email'];
        $password = $user['password'];
        $response = $this->db->getRepository(User::class)->authenticate($email, $password);
        if ($response == true) {
            $authToken = $this->createToken($user);
            return new Response($authToken);
        } else {
            return new Response(Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Method to create token for valid user.
     */
    public function createToken($user)
    {

        return $this->authEncoder->encode(
            [
            'user_email' => $user['email'],
            'user_role' => $user['role']
            ]
        );
    }
}
