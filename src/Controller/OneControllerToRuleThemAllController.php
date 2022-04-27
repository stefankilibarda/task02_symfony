<?php

namespace App\Controller;

use App\Repository\RentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OneControllerToRuleThemAllController extends AbstractController
{
    #[Route('/all', name: 'all')]
    public function all(RentRepository $rentRepository)
    {
        return $this->render('one_controller_to_rule_them_all/index.html.twig', ['rents' => $rentRepository->findAll()]);
    }
}
