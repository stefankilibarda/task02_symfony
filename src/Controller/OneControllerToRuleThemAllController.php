<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OneControllerToRuleThemAllController extends AbstractController
{
    #[Route('/one/controller/to/rule/them/all', name: 'app_one_controller_to_rule_them_all')]
    public function index(): Response
    {
        return $this->render('one_controller_to_rule_them_all/index.html.twig', [
            'controller_name' => 'OneControllerToRuleThemAllController',
        ]);
    }
}
