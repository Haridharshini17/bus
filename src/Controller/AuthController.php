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
    public const REGISTER_USER = 'User Registered Successfully';
    public const USER_EXISTS = 'User Already Exists';
    public const INVALID_USER = 'Invalid User';
    /**
     * Method to register user.
     */
    public function __construct(AuthService $authService, AuthEncoder $encoder)
    {
        $this->authEncoder = $encoder;
        $this->authService = $authService;
        $this->repo = $this->authService->db->getRepository(User::class);
    }

    public function register(Request $request)
    {
        $user = new User;
        $this->getAuthFormDetails(AuthForm::class, $user, $request);
        $registeredEmail = $this->repo->authenticate($user->getEmail(), $user->getPassword());
        if ($registeredEmail) {
            return $this->reportError(
                self::USER_EXISTS,
                Response::HTTP_UNAUTHORIZED
            );
        }
        $this->authService->register($user);

        return $this->renderResponse(self::REGISTER_USER);
    }

    /**
     * Method to authenticate user.
     */
    public function authenticate(Request $request)
    {
        $user = json_decode($request->getContent(), true);
        $response = $this->repo->authenticate($user['email'], $user['password']);
        if ($response) {
            $authToken = $this->createToken($user);
            return $this->renderResponse($authToken);
        } else {
            return $this->reportError(
                self::INVALID_USER,
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Method to create token for valid user.
     */
    public function createToken($user)
    {
        return $this->authEncoder->encode(
            [
            'userEmail' => $user['email'],
            'userRole' => $user['role']
            ]
        );
    }
}
