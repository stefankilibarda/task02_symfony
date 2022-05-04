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

    #[Route('/', name: 'index')]
    public function home()
    {
        
        return $this->render('one_controller_to_rule_them_all/index.html.twig');
    }

    #[Route('/all-deliverers', name: 'all-deliverers')]
    public function allDeliverers(DelivererRepository $delivererRepository, RentRepository $rentRepository)
    {

        $deliverers = $delivererRepository->findAll();

        foreach($deliverers as $deliverer) {
         $lastVehicle = $delivererRepository->lastReservedVehicle($deliverer->getId());
        if($lastVehicle->getRents()[0] !== null)
        {
          $vehicle = $lastVehicle->getRents()[0]->getVehicle();
          $vehicleBrand = $vehicle->getBrand();
          $deliverer->lastVehicle = $vehicleBrand;

        } else {
          $deliverer->lastVehicle = "No reservation history";
        }
        
    }
    
    // dd($deliverers);



        return $this->render('one_controller_to_rule_them_all/deliverers.html.twig', [
            'deliverers' => $deliverers,
            'rents' => $rentRepository->findAll()
        ]);

        
    }

    #[Route('/all-vehicles', name: 'all-vehicle')]
    public function allVehicle(VehicleRepository $vehicleRepository)
    {
        
        return $this->render('one_controller_to_rule_them_all/vehicles.html.twig', [
            'vehicles' => $vehicleRepository->findAll()
        ]);
    }

    #[Route('/all-reservations', name: 'all-reservations')]
    public function allReservations(RentRepository $rentRepository)
    {
        
        return $this->render('one_controller_to_rule_them_all/reservations.html.twig', [
            'rents' => $rentRepository->findAll()
        ]);
    }

    #[Route('/add-deliverer', name: 'add-deliverer')]
    public function addNewDeliverer(DelivererRepository $delivererRepository, Request $request)
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

    #[Route('/reservation-history-deliverer/{id}', name: 'reservation-history-deliverer', methods: ['GET', 'PUT'])]
    public function reservevationHistoryDeliverers($id, DelivererRepository $delivererRepository)
    {
        $deliverer = $delivererRepository->find($id);

        $rents = $deliverer->getRents();

        return $this->render('one_controller_to_rule_them_all/reservations-history-deliverer.html.twig', ['rents' => $rents]);
        
    }

    #[Route('/reservation-history-vehicle/{id}', name: 'reservation-history-vehicle', methods: ['GET', 'PUT'])]
    public function reservevationHistoryVehicle($id, VehicleRepository $vehicleRepository)
    {
        $vehicle = $vehicleRepository->find($id);

        $rents = $vehicle->getRents();

        return $this->render('one_controller_to_rule_them_all/reservations-history-vehicle.html.twig', ['rents' => $rents]);
        
    }

    
}
