<?php

namespace App\Controller;

use App\Entity\Event;
use App\Service\DistanceCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly DistanceCalculator $distanceCalculator,
    ) {
    }

    #[Route('/', name: 'app_event', methods: ['GET'])]
    public function listEvents(): Response
    {
        $events = $this->entityManager->getRepository(Event::class)->findAll();

        return $this->render('event/list.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/event/{id}', name: 'app_event_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/view.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route("/events/{id}/distance", name:"event_distance")]
    public function calculateDistanceToEvent(
        int $id,
        #[MapQueryParameter] float $lat,
        #[MapQueryParameter] float $lon
    ) {
        $event = $this->entityManager->getRepository(Event::class)->find($id);
        $eventLat = $event->getLatitude();
        $eventLon = $event->getLongitude();


        $distance = $this->distanceCalculator->calculateDistance($lat, $lon, $eventLat, $eventLon);

        return $this->render('event/distance.html.twig', [
            'event' => $event,
            'distance' => $distance,
        ]);
    }
}
