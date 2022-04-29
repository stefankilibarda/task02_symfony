<?php

namespace App\Controller;

use App\Entity\Deliverer;
use App\Entity\Vehicle;
use App\Form\DelivererType;
use App\Form\VehicleType;
use App\Repository\DelivererRepository;
use App\Repository\RentRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OneControllerToRuleThemAllController extends AbstractController
{
    #[Route('/all', name: 'all')]
    public function all(RentRepository $rentRepository, DelivererRepository $delivererRepository, Request $request)
    {
        $deliverer = new Deliverer();
        

        
        return $this->render('one_controller_to_rule_them_all/index.html.twig', [
            'rents' => $rentRepository->findAll()
        ]);

        
    }

    #[Route('/add-driver', name: 'add-driver')]
    public function addNewDriver(DelivererRepository $delivererRepository, Request $request)
    {
        $deliverer = new Deliverer();
        $form = $this->createForm(DelivererType::class, $deliverer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $deliverer = $form->getData();
            $delivererRepository->add($deliverer);
            return $this->redirectToRoute('all');
        }

        
        return $this->render('deliverer/add.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/add-vehicle', name: 'add-vehicle')]
    public function addNewVehicle(RentRepository $rentRepository, VehicleRepository $vehicleRepository, Request $request)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle = $form->getData();
            $vehicleRepository->add($vehicle);
            return $this->redirectToRoute('all');
        }

        
        return $this->render('one_controller_to_rule_them_all/add-vehicle.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/reserve-vehicle', name: 'reserve-vehicle')]
    public function reserveVehicle($id, DelivererRepository $delivererRepository)
    {
        // $deliverer = $delivererRepository-find($id);
    }

    
}
