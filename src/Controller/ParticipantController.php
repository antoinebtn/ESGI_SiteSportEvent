<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParticipantController extends AbstractController
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/events/{eventId}/participants/new', name: 'app_add_participant')]
    public function addParticipant(int $eventId, Request $request): Response
    {
        $event = $this->entityManager->getRepository(Event::class)->findOneBy(['id' => $eventId]);

        $participant = new Participant();

        $form = $this->createForm(ParticipantType::class, $participant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();
            $participant->setEvent($event);

            if ($event->getDate() < new \DateTime('now')) {
                $error = "Cet événement est déjà passé, vous ne pouvez plus vous inscrire";

                $this->addFlash('error', $error);
                return $this->redirectToRoute('app_add_participant', ['eventId' => $event->getId()]);
            }

            foreach ($participant->getEvent()->getParticipants() as $participant) {
                if ($participant->getEmail() === $participant->getEmail()) {
                    $error = "Cette adresse mail a déjà été utilisée pour cette événement";

                    $this->addFlash('error', $error);
                    return $this->redirectToRoute('app_add_participant', ['eventId' => $event->getId()]);
                }
            }

            $this->entityManager->persist($participant);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_event_show', ['id' => $eventId]);
        }

        return $this->render('participant/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
}
