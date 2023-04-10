<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface as AuthEncoder;
use App\Entity\Bus;
use App\Entity\Driver;
use App\Form\Type\BusForm;
use App\Repository\UserRepository;

class BusController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->db = $doctrine->getManager();
        $this->repo = $this->db->getRepository(Bus::class);
    }

	public function insertBus(Request $request, ManagerRegistry $doctrine) 
	{
		$bus = new Bus;
		$createForm = $this->createForm(BusForm::class, $bus);
		$createForm->handleRequest($request);
		$createForm->submit(json_decode($request->getContent(), true));
		if ($createForm->isSubmitted()) {
			$user = $createForm->getData();
			$entityManager = $doctrine->getManager();
			$entityManager->persist($user);
			$entityManager->flush($user);

			return new Response(Response::HTTP_CREATED);
		}

	}
   
}