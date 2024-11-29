<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/event', name: 'app_event', methods: ['GET'])]
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
}
